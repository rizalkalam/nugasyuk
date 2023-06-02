<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Ortu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrtuProfileController extends Controller
{
    public function index()
    {
        $data = Ortu::join('murids', 'murids.id', '=', 'ortus.siswa_id')
        ->where('ortus.id', auth()->user()->id)
        ->select(['ortus.email', 'ortus.nama', 'murids.nama_siswa'])
        ->get();

        return response()->json([
            "success" => true,
            "message" => "Data profile",
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
        
            Ortu::where('id', auth()->user()->id)->update([
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