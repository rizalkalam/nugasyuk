<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Hari;
use App\Models\Murid;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrtuJadwalController extends Controller
{
    public function index()
    {
        // *ADA REVISI!!!* //

        // $data = Hari::select(['id', 'hari'])->get();

        $data = Hari::orderBy('id', 'ASC')
        ->select(['id', 'hari'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Hari",
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $kelas_murid = Murid::where('id', auth()->user()->siswa_id)
        ->value('kelas_id');

        $data = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->join('jams', 'jams.id', '=', 'jadwals.jam_id')
        ->where('mapels.kelas_id', $kelas_murid)
        ->where('haris.id', $id)
        ->select(['jadwals.id', 'kodes.nama_mapel', 'gurus.nama_guru', 'jams.waktu_mulai', 'jams.waktu_selesai'])->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Jadwal Mapel Murid",
            "data" => $data,
        ], 200);
    }
}
