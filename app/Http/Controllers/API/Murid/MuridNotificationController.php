<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class MuridNotificationController extends Controller
{
    public function index()
    {
        $tugas_sekarang = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->whereDate('date', '=', Carbon::now()->format('Y-m-d'))
        ->select([
            'tugas.id',
            'tugas.nama_tugas',
            'gurus.nama_guru',
        ])->get();

        $tugas_kemarin = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->whereDate('date', '=', Carbon::yesterday()->format('Y-m-d'))
        ->select([
            'tugas.id',
            'tugas.nama_tugas',
            'gurus.nama_guru',
        ])->get();

        $materi_sekarang = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->whereDate('tanggal_dibuat', '=', Carbon::now()->format('Y-m-d'))
        ->select([
            'materis.id',
            'materis.nama_materi',
            'gurus.nama_guru',
        ])->get();

        $materi_kemarin = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->whereDate('tanggal_dibuat', '=', Carbon::yesterday()->format('Y-m-d'))
        ->select([
            'materis.id',
            'materis.nama_materi',
            'gurus.nama_guru',
        ])->get();

        $data = [
            "tugas_sekarang" => $tugas_sekarang,
            "materi_sekarang" => $materi_sekarang,
            "tugas_kemarin" => $tugas_kemarin,
            "materi_kemarin" =>$materi_kemarin
        ];

        return response()->json([
            "success" => true,
            "message" => "List Notifikasi",
            "data" => $data,
        ], 200);
    }
}
