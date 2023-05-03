<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function index()
    {
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->where('pengumpulans.murid_id', '=', auth()->user()->id)
        ->where('mapels.kelas_id', '=', auth()->user()->kelas_id)
        ->get(['status', 'tugas.id', 'tugas.soal', 'tugas.date', 'tugas.deadline']);

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "tugas" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $data = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->where('mapels.kelas_id', '=', auth()->user()->kelas_id)
        ->where('tugas.id', $id)
        ->get(['tugas.id', 'soal', 'tugas.date', 'tugas.deadline']);

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "tugas" => $data,
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
}
