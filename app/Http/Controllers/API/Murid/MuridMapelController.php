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
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('kelas_id', auth()->user()->kelas_id)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.nama_guru', 'mapels.kelas_id', 'assets.file_asset'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Mata Pelajaran",
            "data" => $mapel,
        ], 200);
    }

    public function detail_mapel($id)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('kelas_id', auth()->user()->kelas_id)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.foto_profile', 'gurus.nama_guru', 'assets.color', 'assets.file_vector'])
        ->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Mata Pelajaran",
            "data" => $mapel,
        ], 200);
    }

    public function materi($id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->orderBy('materis.created_at', 'DESC')
        ->orderBy('materis.tanggal_dibuat', 'DESC')
        ->select(['materis.id', 'materis.nama_materi', 'gurus.nama_guru', 'materis.tanggal_dibuat'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Materi",
            "data" => $materi,
        ], 200);
    }

    public function tugas($id)
    {
        $tugas = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->orderBy('deadline', 'ASC')
        ->select([ 'pengumpulans.id', 'pengumpulans.tugas_id', 'pengumpulans.status', 'tugas.nama_tugas', 'tugas.soal', 'gurus.nama_guru', 'tugas.date', 'tugas.deadline', 'tugas.status_tugas', 'tugas.file_tugas', 'tugas.link_tugas', 'pengumpulans.file', 'pengumpulans.link'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $tugas,
        ], 200);
    }

    public function detail_materi($id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('materis.id', $id)
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->select([
            'materis.id',
            'kodes.nama_mapel',
            'materis.nama_materi',
            'materis.isi',
            'gurus.nama_guru',
            'materis.tanggal_dibuat',
            'materis.file',
            'materis.link'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List Materi",
            "data" => $materi,
        ], 200);
    }
}
