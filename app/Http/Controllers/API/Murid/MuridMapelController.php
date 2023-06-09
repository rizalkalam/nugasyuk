<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MuridMapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('kelas_id', auth()->user()->kelas_id)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.nama_guru', 'mapels.kelas_id'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Mata Pelajaran",
            "kelas" => $mapel,
        ], 200);
    }

    public function detail_mapel($id)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('kelas_id', auth()->user()->kelas_id)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.nama_guru'])->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Mata Pelajaran",
            "mapel" => $mapel,
        ], 200);
    }

    public function materi($id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->select(['materis.nama_materi', 'gurus.nama_guru', 'materis.tanggal_dibuat'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Materi",
            "data" => $materi,
        ], 200);
    }

    public function tugas($id)
    {
        $tugas = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->select(['tugas.id', 'pengumpulans.status', 'tugas.soal', 'gurus.nama_guru', 'tugas.deadline'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $tugas,
        ], 200);
    }
}
