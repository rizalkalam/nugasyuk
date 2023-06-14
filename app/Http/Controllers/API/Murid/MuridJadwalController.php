<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Hari;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResource;

class MuridJadwalController extends Controller
{
    public function index()
    {
        $hari = Hari::orderBy('id', 'ASC')
        ->select(['id', 'hari'])->get();

        $foto = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->orderBy('haris.id', 'ASC')
        ->select(['gurus.foto_profile'])->get();

        $data = JadwalResource::collection($hari);

        return response()->json([
            "success" => true,
            "message" => "List Jadwal",
            "data" => $data
        ], 200);
    }

    public function detail($id)
    {
        $data = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->join('jams', 'jams.id', '=', 'jadwals.jam_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->where('haris.id', $id)
        ->select(['jadwals.id', 'kodes.nama_mapel', 'gurus.foto_profile', 'gurus.nama_guru', 'jams.waktu_mulai', 'jams.waktu_selesai'])->get();

        $hari = Hari::where('id', $id)
        ->select(['id', 'hari'])->value('hari');

        return response()->json([
            "success" => true,
            "message" => "Detail Jadwal Mapel Murid",
            "hari"=>$hari,
            "data" => $data,
        ], 200);
    }
}
