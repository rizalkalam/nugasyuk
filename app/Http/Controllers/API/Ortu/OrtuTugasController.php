<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Ortu;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailTugasResource;

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
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->where('pengumpulans.murid_id', '=', auth()->user()->siswa_id)
        ->where('kelas.id', '=', $kelas_id)
        ->when($status,function ($query) use ($status){
            $query->where('status', $status);
        })
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('kodes.status_mapel', $status_mapel);
        })
        ->when($soal, function ($query) use ($soal){
            $query->where('tugas.soal', 'LIKE', '%' . $soal . '%');
        })
        ->select([
            'pengumpulans.id',
            'pengumpulans.tugas_id',
            'pengumpulans.status',
            'gurus.nama_guru',
            'tugas.nama_tugas',
            'tugas.soal',
            'tugas.date',
            'tugas.deadline',
            'kodes.status_mapel'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "tugas" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $data_pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
            ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('pengumpulans.id', $id)
            ->where('pengumpulans.murid_id', auth()->user()->siswa_id)
            ->get([
                'pengumpulans.id',
                'pengumpulans.tugas_id',
                'gurus.nama_guru',
                'kodes.nama_mapel',
                'tugas.nama_tugas',
                'tugas.soal',
                'tugas.date',
                'tugas.deadline',
                'pengumpulans.status',
                'pengumpulans.link',
                'pengumpulans.file'
            ]);

        // $data = DetailTugasResource::collection($data_pengumpulan);

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $data_pengumpulan,
        ], 200);
    }
}
