<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BerandaGuruResource;

class BerandaController extends Controller
{
    public function test()
    {
        return response()->json([
            'tes'=>'coba',
            'tes2'=>'hello world!'
        ]);
    }

    public function data_guru()
    {
        $guru = Guru::where('id', auth()->user()->id)->value('nama_guru');

        $kelas = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)->select('mapels.kelas_id')->get()->count();


        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)->select('materis.id')->get()->count();


        // $tugas = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        // ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        // ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        // ->where('kodes.guru_id', '=', auth()->user()->id)
        // ->get('tugas.id');

        // $jumlah_tugas = count($tugas);

        $jumlah_menunggu = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'menunggu')
        ->select('pengumpulans.id')
        ->get()->count();

        $jumlah_selesai = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->select('pengumpulans.id')
        ->get()->count();

        $data = [
            "nama_guru" => $guru,
            "jumlah_kelas" => $kelas,
            "jumlah_materi" => $materi,
            "menunggu" => $jumlah_menunggu,
            "selesai" => $jumlah_selesai
        ];

        return response()->json([
            "data" => $data
        ], 200);
    }

    public function index()
    {
        return response()->json([
            "nama_guru" =>auth()->user()->nama_guru,
            "mapel_guru"=>$mata_pelajaran,
            "mengajar"=>$kelas,
            "materi_diberikan"=>$materi,
            "tugas_diberikan"=>$tugas
        ], 200);
    }
}
