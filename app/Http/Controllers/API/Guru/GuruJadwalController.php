<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Hari;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuruJadwalController extends Controller
{
    public function index()
    {
        $hari = request ('hari', 1);

        $data_hari = Hari::where('id', $hari)->value('hari');

        $data = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->join('jams', 'jams.id', '=', 'jadwals.jam_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('gurus.id', auth()->user()->id)
        ->when($hari, function ($query) use ($hari){
            return $query->whereHas('hari', function ($query) use ($hari){
                $query->where('id', $hari);
            });
        })
        ->orderBy('jams.id', 'ASC')  
        ->select([
            'jadwals.id',
            // 'haris.hari',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'kodes.nama_mapel',
            'jams.waktu_mulai',
            'jams.waktu_selesai'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "Jadwal Mapel Murid",
            "hari" => $data_hari,
            "data" => $data,
        ], 200);
    }
}
