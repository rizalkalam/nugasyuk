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
        ->join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
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
        ->select(['status', 'tugas.id', 'tugas.soal', 'tugas.date', 'tugas.deadline', 'materis.id'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "tugas" => $data,
        ], 200);
    }
}
