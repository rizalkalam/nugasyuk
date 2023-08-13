<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Murid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MuridProfileController extends Controller
{
    public function index()
    {
        $data = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('murids.id', auth()->user()->id)
        ->select([
            'murids.id',
            'murids.foto_profile',
            'murids.email',
            'murids.nama_panggilan',
            'murids.nama_siswa', 
            'jurusans.nama_jurusan',
            'tingkatans.tingkat_ke',
            'murids.nis'
            ])->get();

            return response()->json([
                "success" => true,
                "message" => "Profile Murid",
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

        $file_path = Murid::where('id', auth()->user()->id)->value('foto_profile');

        if ($request->hasFile('foto_profile')) {
            Storage::delete($file_path);
            $berkas = $request->file('foto_profile');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('gambar_profile_siswa', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $murid = Murid::where('id', auth()->user()->id)->first();

            $murid->update([
                'foto_profile' => $edit,
            ]);

            return response()->json([
                'message' => 'Foto profile berhasil diubah',
                'data' => $murid,
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
                'konfirmasi'=>'required|min:5|max:255|same:password_baru',
            ]);
            
            if ($validateData->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validateData->errors(),
                    'data' => [],
                ]);
            }
        
                Murid::where('id', auth()->user()->id)->update([
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
