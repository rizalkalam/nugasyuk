<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Ortu;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrtuTugasController extends Controller
{
    public function tugas()
    {
        $kelas_id = Ortu::join('murids', 'murids.id', '=', 'ortus.siswa_id')
        ->where('murids.id', auth()->user()->id)
        ->value('murids.kelas_id');

        $status = request ('status', null);
        $status_mapel = request('status_mapel', null);
        $soal = request('soal', null);
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->where('pengumpulans.murid_id', '=', auth()->user()->siswa_id)
        ->where('kelas.id', '=', $kelas_id)
        ->when($status,function ($query) use ($status){
            $query->where('status', $status);
        })
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('mapels.status_mapel', $status_mapel);
        })
        ->when($soal, function ($query) use ($soal){
            $query->where('tugas.soal', 'LIKE', '%' . $soal . '%');
        })
        ->select(['status', 'tugas.id', 'nama_tugas', 'tugas.soal', 'tugas.date', 'tugas.deadline'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "tugas" => $data,
        ], 200);
    }

    public function detail()
    {
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
            ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('mapels.id', $id)
            ->where('pengumpulans.murid_id', auth()->user()->id)
        ->get(['tugas.id', 'nama_tugas', 'soal', 'pengumpulans.status', 'tugas.date', 'tugas.deadline']);

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $data,
        ], 200);
    }
}
