<?php

namespace App\Http\Controllers\API\Konseling;

use App\Models\Mapel;
use App\Models\Janjian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class KonselingJanjiController extends Controller
{
    public function index()
    {
        $data_guru = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('gurus.id', auth()->user()->id)
        ->select([
            'gurus.nama_guru',
            'jurusans.nama_jurusan'
        ])
        ->first();

        $data_janji = Janjian::join('murids', 'murids.id', '=', 'janjians.murid_id')
        ->join('jams', 'jams.id', '=', 'janjians.jam_id')
        ->where('janjians.guru_id', auth()->user()->id)
        ->whereDate('tanggal', '=', Carbon::now()->format('Y-m-d'))
        ->select([
            'murids.nama_siswa',
            'janjians.topik',
            'janjians.tanggal',
            'janjians.jam_id',
            // 'janjians.lokasi'
        ])
        ->orderBy('jams.id', 'ASC')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'tes',
            'guru' => $data_guru->nama_guru,
            'jurusan' => $data_guru->nama_jurusan,
            'data' => $data_janji
        ]);
    }
}
