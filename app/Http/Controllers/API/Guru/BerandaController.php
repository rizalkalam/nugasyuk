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
        ->where('kodes.guru_id', auth()->user()->id)->get('mapels.kelas_id');

        $jumlah_kelas = count($kelas);

        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->get('materis.id');

        $jumlah_materi = count($materi);

        $tugas = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', '=', auth()->user()->id)
        ->get('tugas.id');

        $jumlah_tugas = count($tugas);
        // $tugas = Tugas::first();

        // $data = [
        //     "nama_guru" => $guru,
        //     "jumlah_kelas" => $jumlah_kelas,
        //     "jumlah_materi" => $jumlah_materi,
        //     "jumlah_tugas" => $jumlah_tugas
        // ];

        return response()->json([
            "success" => true,
            "message" => "Jumlah Kelas Diampu",
            // "data_guru" => $data
            "nama_guru" => $guru,
            "jumlah_kelas" => $jumlah_kelas,
            "jumlah_materi" => $jumlah_materi,
            "jumlah_tugas" => $jumlah_tugas
        ]);
    }

    public function index()
    {
        // $profile[]=[
        //     'nama_guru'=>auth()->user()->nama_guru,
        //     'foto_profile'=>auth()->user()->foto_profile,
        // ];

        // jumlah kelas yang diajar
        

        // jumlah materi yang diberikan
        

        // jumlah tugas yang diberika

        return response()->json([
            "success" => true,
            "message" => "Beranda Guru",
            // "profile_guru" => $profile,
            "nama_guru" =>auth()->user()->nama_guru,
            "mapel_guru"=>$mata_pelajaran,
            "mengajar"=>$kelas,
            "materi_diberikan"=>$materi,
            "tugas_diberikan"=>$tugas
        ], 200);
    }
}
