<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::select(['nama', 'email'])->get();

        $data = [
            "nama" => $admin->first()->nama,
            "email" => $admin->first()->email,
            "divisi" => "Admin"
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Admin",
            "data" => $data,
        ], 200);
    }

    public function resetpassword(Request $request)
    {
        if (Hash::check($request->password_lama, auth()->user()->password)) {    
            $validateData = Validator::make($request->all(),[
                'password'=>'required|min:5|max:255',
                'konfirmasi'=>'required|min:5|max:255|same:password',
                // 'updated_at' => now()
            ]);

            if ($validateData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validateData->errors(),
                    'data' => [],
                ]);
            }
        
            Admin::where('id', auth()->user()->id)->update([
                'password'=>Hash::make($request->password),
                // 'konfirmasi'=>Hash::make($request->konfirmasi),
                'updated_at' => now()
            ]);
            return response()->json([
                'message' => 'password changed successfully',
                // 'data' => $data
            ],200);
        
        }

        return response()->json([
            'message' => 'forbidden',
            'errors' => 'passwords do not match'
        ],403);
    }
}
