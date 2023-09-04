<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    public function tugas()
    {
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
            $query->where('kodes.status_mapel', $status_mapel);
        })
        ->when($soal, function ($query) use ($soal){
            $query->where('tugas.soal', 'LIKE', '%' . $soal . '%');
        })
        ->orderBy('deadline', 'ASC')
        ->select([
            'pengumpulans.id',
            'pengumpulans.tugas_id',
            'pengumpulans.status',
            'nama_tugas',
            'tugas.soal',
            'gurus.nama_guru',
            'tugas.date',
            'tugas.deadline',
            'tugas.status_tugas',
            'kodes.status_mapel'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List Tugas",
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $tugas = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('pengumpulans.id', $id)
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->select([
            'kodes.nama_mapel',
            'pengumpulans.id',
            'pengumpulans.tugas_id',
            'pengumpulans.status',
            'tugas.nama_tugas',
            'tugas.soal',
            'gurus.nama_guru',
            'tugas.date',
            'tugas.deadline',
            'tugas.file_tugas',
            'tugas.link_tugas',
            'tugas.status_tugas',
            'pengumpulans.file',
        ])
        ->get();

        return response()->json([
            "success" => true,
            "message" => "Detail Tugas",
            "data" => $tugas,
        ], 200);
    }

    public function kirim(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            // 'link'=> 'required',
            'file'=> 'mimes:pdf,docx,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        try {

            $deadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
            ->where('pengumpulans.id', $id)
            ->value('tugas.deadline');

            $data_kiriman = Pengumpulan::where('id', $id)
            ->where('murid_id', auth()->user()->id)
            ->first();

            $berkas = $request->file('file');

            if ($deadline >= Carbon::now()->format('Y-m-d')) {
                if (empty($berkas)) {
                    $data_kiriman->update([
                        'status'=>'menunggu_dalam_deadline',
                        'link'=> $request->link,
                        'tanggal'=>Carbon::now()->format('Y-m-d')
                        // 'file'=> $berkas->storeAs('file', $nama),
                    ]);

                    return response()->json([
                        'message' => 'Jawaban berhasil terkirim',
                        'data' => $data_kiriman,
                        // 'status' => $status
                    ]);
                }
                $nama = $berkas->getClientOriginalName();
                $data_kiriman->update([
                    'status'=>'menunggu_dalam_deadline',
                    'link'=> $request->link,
                    'file'=> $berkas->storeAs('file', $nama),
                    'tanggal'=>Carbon::now()->format('Y-m-d')
                ]);
    
                return response()->json([
                    'message' => 'Jawaban berhasil terkirim',
                    'data' => $data_kiriman,
                    // 'status' => $status
                ]);
            } 
                if (empty($berkas)) {
                    $data_kiriman->update([
                        'status'=>'menunggu_lebih_deadline',
                        'link'=> $request->link,
                        'tanggal'=>Carbon::now()->format('Y-m-d')
                        // 'file'=> $berkas->storeAs('file', $nama),
                    ]);
    
                    return response()->json([
                        'message' => 'Jawaban berhasil terkirim',
                        'data' => $data_kiriman,
                        // 'status' => $status
                    ]);
                }
                $nama = $berkas->getClientOriginalName();
                $data_kiriman->update([
                    'status'=>'menunggu_lebih_deadline',
                    'link'=> $request->link,
                    'file'=> $berkas->storeAs('file', $nama),
                    'tanggal'=>Carbon::now()->format('Y-m-d')
                ]);
    
                return response()->json([
                    'message' => 'Jawaban berhasil terkirim',
                    'data' => $data_kiriman,
                    // 'status' => $status
                ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }        
    }

    public function hapus_file($id)
    {
        $file_path = Pengumpulan::where('id', $id)->value('file');

        if (!empty($file_path)) {
            Storage::delete($file_path);
        }

        $file = Pengumpulan::where('id', $id)
        ->update([
            'file' => null
        ]);

        return response()->json([
            'message' => "file terhapus, status berubah 'belum_selesai'",
            // 'data' => $jawaban,
        ]);

    }
}
