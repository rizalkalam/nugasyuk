<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Murid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
