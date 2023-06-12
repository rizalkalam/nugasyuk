<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                'kelas_id'=>auth()->guard('murid')->user()->kelas_id
            ]);
        } elseif ($token = auth()->guard('ortu')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->guard('ortu')->user()->email,
                'siswa_id'=>auth()->guard('ortu')->user()->siswa_id
            ]);
        } elseif ($token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'akun'=>auth()->guard('admin')->user()->email
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
