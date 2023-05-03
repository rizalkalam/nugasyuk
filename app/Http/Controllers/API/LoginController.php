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

        if ($token = auth()->guard('guru')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->user()->email
            ]);
        } elseif ($token = auth()->guard('murid')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->guard('murid')->user()->email
            ]);
        } elseif ($token = auth()->guard('ortu')->attempt($credentials)) {
            return response()->json([
                'token'=>$token,
                'account'=>auth()->guard('ortu')->user()->email
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
