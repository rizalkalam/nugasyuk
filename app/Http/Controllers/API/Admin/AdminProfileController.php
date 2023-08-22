<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::select(['nama', 'email', 'foto_profile'])->get();

        $data = [
            "nama" => $admin->first()->nama,
            "email" => $admin->first()->email,
            "foto_profile" => $admin->first()->foto_profile,
            "divisi" => "Admin"
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Admin",
            "data" => $data,
        ], 200);
    }

    public function ubah_password(Request $request)
    {
        if (Hash::check($request->password_lama, auth()->user()->password)) {    
            $validateData = Validator::make($request->all(),[
                'password_baru'=>'required|min:5|max:255',
                // 'konfirmasi'=>'required|min:5|max:255|same:password_baru',
            ]);
            
            if ($validateData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validateData->errors(),
                    'data' => [],
                ]);
            }
        
                Admin::where('id', auth()->user()->id)->update([
                    'password'=>Hash::make($request->password_baru),
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
    
    public function edit_foto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_profile' => 'mimes:jpeg,png,jpg|file|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        $file_path = Admin::where('id', auth()->user()->id)->value('foto_profile');

        if ($request->hasFile('foto_profile')) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('gambar_profile_guru', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $admin = Admin::where('id', auth()->user()->id)->first();

            $admin->update([
                'foto_profile' => $edit,
            ]);

            return response()->json([
                'message' => 'Foto profile berhasil diubah',
                'data' => $admin,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
    }
}
