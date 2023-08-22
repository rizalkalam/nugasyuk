<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', auth()->user()->id)
        ->select(['foto_profile', 'email', 'nama_guru'])->first();

        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->select(['kodes.nama_mapel'])->get();

        $data = [
            "foto_profile" => $profile->foto_profile,
            "email" => $profile->email,
            "nama_guru" => $profile->nama_guru,
            "mapel" => $mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Guru",
            "data" => $data,
        ], 200);
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

        $file_path = Guru::where('id', auth()->user()->id)->value('foto_profile');

        if ($request->hasFile('foto_profile')) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('gambar_profile_guru', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $guru = Guru::where('id', auth()->user()->id)->first();

            $guru->update([
                'foto_profile' => $edit,
            ]);

            return response()->json([
                'message' => 'Foto profile berhasil diubah',
                'data' => $guru,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
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
        
                Guru::where('id', auth()->user()->id)->update([
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
}