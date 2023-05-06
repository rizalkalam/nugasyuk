<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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

        //   Auth::user()->createToken('auth_token')->plainTextToken;

        if ($token = auth()->guard('guru')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->user()->email,
                'mapel_id'=>auth()->user()->mapel_id
            ]);
        } elseif ($token = auth()->guard('murid')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->guard('murid')->user()->email,
                'kelas_id'=>auth()->guard('murid')->user()->kelas_id
            ]);
        } elseif ($token = auth()->guard('ortu')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'siswa_id'=>auth()->guard('ortu')->user()->siswa_id
            ]);
        } elseif ($token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->guard('admin')->user()->email
            ]);
        } else {
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }

    public function test()
    {
        return response()->json([
            'tes'=>'coba',
            'tes2'=>'hello world!'
        ]);
    }
    
    // public function loginMurid(Request $request)
    // {
    //     $request->validate([
    //         'email'=>'required',
    //         'password'=>'required'
    //     ]);

    //     if (!$token = auth()->guard('murid')->attempt($request->only('email', 'password'))) {
    //        return response()->json(['error'=>'Unauthorized'], 401);
    //     }

    //     return response()->json([
    //             'token'=>$token,
    //             'account'=>Auth::guard('murid')->user()->email
    //         ]);
    // }

    // public function loginOrtu(Request $request)
    // {
    //     $request->validate([
    //         'email'=>'required',
    //         'password'=>'required'
    //     ]);

    //     if (!$token = auth()->guard('ortu')->attempt($request->only('email', 'password'))) {
    //        return response()->json(['error'=>'Unauthorized'], 401);
    //     }

    //     return response()->json([
    //             'token'=>$token,
    //             'account'=>Auth::guard('ortu')->user()->email
    //         ]);
    // }
}
