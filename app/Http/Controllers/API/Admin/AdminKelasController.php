<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminKelasController extends Controller
{
    public function index()
    {
        $jurusan = request('jurusan', null);
        $data = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
            return $query->whereHas('jurusan', function ($query) use ($jurusan) {
                $query->where('id', $jurusan);
            });   
        })
        ->orderBy('tingkatans.tingkat_ke', 'ASC')
        ->orderBy('jurusans.id')
        ->select(['kelas.id', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas'])->get();

        $jumlah_kelas = count(Kelas::all());

        return response()->json([
            "success" => true,
            "message" => "List Kelas",
            "jumlah_kelas" => $jumlah_kelas,
            "data" => $data,
        ], 200);
    }

    public function detail_kelas($id)
    {
        $kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', $id)
        ->select([
            'kelas.id',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'gurus.nama_guru',
            ])->first();
        
        $tinkgatan_id = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('kelas.id', $id)
        ->value('tingkatans.id');

        $jurusan_id =  Kelas::join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kelas.id', $id)
        ->value('jurusans.id');

        $guru_id = Kelas::join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', $id)
        ->value('gurus.id');

        $data = [
            'id'=>$kelas->id,
            'tingkat_ke'=>$kelas->tingkat_ke,
            'nama_jurusan'=>$kelas->nama_jurusan,
            'nama_kelas'=>$kelas->nama_kelas,
            'wali_kelas'=>$kelas->nama_guru,
            'tingkatan_id'=>$tinkgatan_id,
            'jurusan_id'=>$jurusan_id,
            'guru_id'=>$guru_id
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Kelas",
            "data" => $data,
        ], 200);
    }

    public function buat_kelas(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_kelas'=> 'required',
            'wali_kelas'=> 'required',
            'jurusan'=> 'required',
            'tingkatan'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $data = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'guru_id' => $request->wali_kelas,
            'jurusan_id' => $request->jurusan,
            'tingkatan_id' => $request->tingkatan,
        ]);

        return response()->json([
            'message' => 'Data Kelas baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_kelas(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_kelas' => 'required',
            'wali_kelas' => 'required',
            'jurusan' => 'required',
            'tingkatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $kelas = Kelas::where('id', $id)->first();

            $kelas->update([
                'nama_kelas' => $request->nama_kelas,
                'guru_id' => $request->wali_kelas,
                'jurusan_id' => $request->jurusan,
                'tingkatan_id' => $request->tingkatan,
            ]);

            return response()->json([
                'message' => 'Data Kelas berhasil di ubah',
                'data' => $kelas,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_kelas($id)
    {
        $kelas = Kelas::where('id', $id)->first();

        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kelas berhasil di hapus',
        ]);
    }
}
