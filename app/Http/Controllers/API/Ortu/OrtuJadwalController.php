<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Hari;
use App\Models\Murid;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResourceWali;

class OrtuJadwalController extends Controller
{
    public function index()
    {
        $hari = Hari::orderBy('id', 'ASC')
        ->select(['id', 'hari'])->get();

        $data = JadwalResourceWali::collection($hari);

        $kelas_siswa = Murid::where('id', auth()->user()->siswa_id)->value('kelas_id');

        return response()->json([
            "success" => true,
            "message" => "List Jadwal",
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
        ->select(['jadwals.id', 'gurus.foto_profile', 'gurus.nama_guru', 'kodes.nama_mapel', 'jams.waktu_mulai', 'jams.waktu_selesai'])->get();

        $hari = Hari::where('id', $id)
        ->select(['id', 'hari'])->value('hari');

        return response()->json([
            "success" => true,
            "message" => "Detail Jadwal",
            "hari" => $hari,
            "data" => $data,
        ], 200);
    }
}
