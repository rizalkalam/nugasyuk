<?php

namespace App\Http\Controllers\API;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Status;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function beranda()
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
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
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

    public function profile()
    {
        $profile = array();
        $profile[]=[
            'foto_profile'=>auth()->user()->foto_profile,
            'email'=>auth()->user()->email,
            'nama_guru'=>auth()->user()->nama_guru,
            'mapel_guru'=>auth()->user()->mapel->kode->nama_mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Guru",
            "profile_guru" => $profile,
        ], 200);
    }
}
