<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Murid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
            'tingkatans.tingkat_ke'
            ])->get();

            return response()->json([
                "success" => true,
                "message" => "Detail Jadwal Mapel Murid",
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
        
            Murid::where('id', auth()->user()->id)->update([
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
