<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function index($id){
        $jadwal = Jadwal::join('kodes', 'kodes.id', '=', 'jadwals.kode_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->join('jams', 'jams.id', '=', 'jadwals.jam_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('gurus.id', auth()->user()->id)
        ->where('jadwals.hari_id', $id)
        ->get([
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'kodes.nama_mapel',
            'haris.hari',
            'jams.waktu_mulai',
            'jams.waktu_selesai'
        ]);

        if (count($jadwal) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "List Jadwal",
                "tugas" => $jadwal,
            ], 200);
        }
    }
}
