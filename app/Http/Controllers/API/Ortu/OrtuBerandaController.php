<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Ortu;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class OrtuBerandaController extends Controller
{
    public function data_ortu()
    {
        $ortu = Ortu::where('id', auth()->user()->id)->value('nama');

        $kelas_siswa = Murid::where('id', auth()->user()->siswa_id)->value('kelas_id');

        $jumlah_murid = Murid::where('kelas_id', $kelas_siswa)->select('id')->get()->count();

        $jumlah_mapel = Mapel::where('kelas_id', $kelas_siswa)
        ->select('id')->get()->count();

        $wali_kelas = Kelas::join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', $kelas_siswa)
        ->value('gurus.nama_guru');

        $data = [
            "nama" => $ortu,
            "jumlah_siswa" => $jumlah_murid,
            "jumlah_mapel" => $jumlah_mapel,
            "wali_kelas" => $wali_kelas
        ];

        return response()->json([
            "data" => $data
        ]);  
    }
}
