<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function tugas()
    {

        // $deadline = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        // ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        // ->where('mapels.kelas_id', auth()->user()->kelas_id)
        // ->value('tugas.deadline');

        // $dalamdeadline = '<=';
        // $lebihdeadline = '>=';

        $status = request ('status', null);
        $status_mapel = request('status_mapel', null);
        $soal = request('soal', null);
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->where('pengumpulans.murid_id', '=', auth()->user()->id)
        ->where('kelas.id', '=', auth()->user()->kelas_id)
        ->when($status,function ($query) use ($status){
            $query->where('status', $status);
        })
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('mapels.status_mapel', $status_mapel);
        })
        ->when($soal, function ($query) use ($soal){
            $query->where('tugas.soal', 'LIKE', '%' . $soal . '%');
        })
        ->select(['tugas.id', 'status', 'nama_tugas', 'tugas.soal', 'gurus.nama_guru', 'tugas.date', 'tugas.deadline'])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
            ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('tugas.id', $id)
            ->where('pengumpulans.murid_id', auth()->user()->id)
        ->get(['tugas.id', 'kodes.nama_mapel', 'nama_tugas', 'soal', 'pengumpulans.status', 'tugas.date', 'tugas.deadline']);

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $data,
        ], 200);
    }

    public function kirim(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            // 'link'=> 'required',
            'file'=> 'file',
            'murid_id'=> 'required'
        ]);

        // $jawaban = Tugas::where('id', $id)
        // ->first('id');

        $jawaban = Pengumpulan::where('tugas_id', $id)
        ->where('status', '=', 'belum selesai')
        ->where('murid_id', '=', auth()->user()->id)
        ->first('id');
        
            $jawaban->update([
                'link'=> $request->link,
                'file'=> $request->file,
                'status'=> 'selesai',
                'murid_id'=> auth()->user()->id
            ]);

            return response()->json([
                'message' => 'Jawaban berhasil terkirim',
                'data' => $jawaban,
            ]);
    }

    public function pengumpulan()
    {
        
    }
}
