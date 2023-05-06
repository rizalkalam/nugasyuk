<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Kode;
use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $profile = array();
        $profile[]=[
            'nama_guru'=>auth()->user()->nama_guru,
            'foto_profile'=>auth()->user()->foto_profile,
        ];

        // mapel guru
        $kode = Kode::all();
        foreach ($kode as $item) {
            if ($item->guru->nama_guru == auth()->user()->nama_guru) {
               $mata_pelajaran[]=[
                'mapel_guru'=>$item->nama_mapel
               ];
            }
        }

        // jumlah kelas yang diajar
        $mapels = Mapel::all();
        foreach ($mapels as $mapel) {
            if ($mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $kelas[]=[
                    'kelas'=>$mapel->kelas->tingkatan->tingkat_ke . ' ' . $mapel->kelas->jurusan->nama_jurusan . ' ' . $mapel->kelas->nama_kelas
                ];
            }
        }

        // jumlah materi yang diberikan
        $materis = Materi::all();
        foreach ($materis as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $materi[]=[
                    'judul'=>$item->judul
                ];
            }
        }

        // jumlah tugas yang diberikan
        $all_tugas = Tugas::all();
        foreach ($all_tugas as $item) {
            if ($item->materi->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $tugas[]=[
                    'judul'=>$item->soal,
                ];
            }
        }

        return response()->json([
            "success" => true,
            "message" => "Beranda Guru",
            "profile_guru" => $profile,
            "mapel_guru"=>$mata_pelajaran,
            "mengajar"=>$kelas,
            "materi_diberikan"=>$materi,
            "tugas_diberikan"=>$tugas
        ], 200);
    }
}
