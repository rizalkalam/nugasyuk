<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class GuruNotificationController extends Controller
{
    public function index()
    {
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('pengumpulans.status', '=','menunggu_lebih_deadline')
        // ->where( function ($query){
        //     return $query
        //     ->orWhere('pengumpulans.status', '=','menunggu_lebih_deadline');
        // })
        ->select([
            'pengumpulans.id',
            'pengumpulans.murid_id',
            'pengumpulans.tugas_id',
            'murids.foto_profile',
            'murids.nama_siswa',
            'murids.email',
            'tugas.nama_tugas',
            'tugas.deadline',
            'pengumpulans.status',
            'pengumpulans.tanggal AS tanggal_mengumpulkan',
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List Notifikasi",
            "data" => $data,
        ], 200);
    }
}
