<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Materi;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrtuMapelController extends Controller
{
    public function index()
    {
        $kelas_murid = Murid::where('id', auth()->user()->siswa_id)
        ->value('kelas_id');

        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('kelas_id', $kelas_murid)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.nama_guru', 'mapels.kelas_id', 'assets.file_asset'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Mata Pelajaran",
            "kelas" => $mapel,
        ], 200);
    }

    public function detail_mapel($id)
    {
        $kelas_murid = Murid::where('id', auth()->user()->siswa_id)
        ->value('kelas_id');

        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('kelas_id', $kelas_murid)
        ->select(['mapels.id', 'kodes.nama_mapel', 'gurus.foto_profile', 'gurus.nama_guru', 'assets.color', 'assets.file_vector'])
        ->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Mata Pelajaran",
            "mapel" => $mapel,
        ], 200);
    }

    public function materi($id)
    {
        $kelas_murid = Murid::where('id', auth()->user()->siswa_id)
        ->value('kelas_id');

        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.id', $id)
        ->where('mapels.kelas_id', $kelas_murid)
        ->select(['materis.nama_materi', 'gurus.nama_guru', 'materis.tanggal_dibuat'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Materi",
            "data" => $materi,
        ], 200);
    }

    public function detail_materi($id)
    {
        $kelas_murid = Murid::where('id', auth()->user()->siswa_id)
        ->value('kelas_id');

        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('materis.id', $id)
        ->where('mapels.kelas_id', $kelas_murid)
        ->select(['materis.nama_materi', 'gurus.nama_guru', 'materis.tanggal_dibuat', 'materis.isi', 'materis.link', 'materis.file'])->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Materi",
            "data" => $materi,
        ], 200);
    }
}
