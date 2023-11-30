<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if ($token = auth()->guard('guru')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->user()->email,
                'mapel_id'=>'ini adalah akun guru'
            ]);
        } elseif ($token = auth()->guard('murid')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->guard('murid')->user()->email,
                'kelas_id'=>'ini adalah akun murid'
            ]);
        } elseif ($token = auth()->guard('ortu')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->guard('ortu')->user()->email,
                'siswa_id'=>'ini adalah akun wali'
            ]);
        } elseif ($token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->guard('admin')->user()->email,
                'admin_id'=>'ini adalah akun admin',
            ]);
        } else {
            return response()->json(['kesalahan'=>'Tidak sah'], 401);
        }
    }

    public function logout()
    {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            //return response JSON
            return response()->json([
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }

    public function wrongtoken()
    {
        return response()->json([
            "kesalahan" => "Tidak sah"
        ],401);
    }
}
