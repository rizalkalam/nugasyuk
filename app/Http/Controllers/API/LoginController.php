<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginGuru(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (!$token = auth()->guard('guru')->attempt($request->only('email', 'password'))) {
           return response()->json(['error'=>'Unauthorized'], 401);
        }

        return response()->json([
            'token'=>$token,
            'account'=>auth()->user()->email
            ]);
    }

    public function loginMurid(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (!$token = auth()->guard('murid')->attempt($request->only('email', 'password'))) {
           return response()->json(['error'=>'Unauthorized'], 401);
        }

        return response()->json([
                'token'=>$token,
                'account'=>Auth::guard('murid')->user()->email
            ]);
    }

    public function loginOrtu(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (!$token = auth()->guard('ortu')->attempt($request->only('email', 'password'))) {
           return response()->json(['error'=>'Unauthorized'], 401);
        }

        return response()->json([
                'token'=>$token,
                'account'=>Auth::guard('ortu')->user()->email
            ]);
    }
}
