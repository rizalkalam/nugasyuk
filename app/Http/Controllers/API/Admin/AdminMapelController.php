<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminMapelController extends Controller
{
    public function index()
    {
        $nama_mapel = request('nama_mapel', null);
        $jurusan = request('jurusan', null);
        $data = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
            return $query->whereHas('kelas', function ($query) use ($jurusan){
                $query->where('jurusan_id', $jurusan);
            });
        })
        ->when($nama_mapel, function ($query) use ($nama_mapel){
            $query->where('kodes.nama_mapel', 'LIKE', '%' . $nama_mapel . '%');
        })
        ->orderBy('mapels.id', 'asc')
        ->select([
            'mapels.id',
            'kodes.nama_mapel',
            'gurus.nama_guru',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'assets.file_asset'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List Mata Pelajaran",
            "data" => $data,
        ], 200);
    }

    public function buat_mapel(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'kode_id' => 'required',
            'kelas_id' => 'required',
            'asset_id' => 'required'
        ]);

        $data = Mapel::create([
            'kode_id' => $request->kode_id,
            'kelas_id' => $request->kelas_id,
            'asset_id' => $request->asset_id
        ]);

        return response()->json([
            'message' => 'Data Mata Pelajaran baru berhasil dibuat',
            'data' => $data,
        ]);
    }

    public function edit_mapel(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'kode_id' => 'required',
            'kelas_id' => 'required',
            'asset_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $mapel = Mapel::where('id', $id)->first();

            $mapel->update([
                'kode_id' => $request->kode_id,
                'kelas_id' => $request->kelas_id,
                'asset_id' => $request->asset_id
            ]);

            return response()->json([
                'message' => 'Data Mata Pelajaran berhasil di ubah',
                'data' => $mapel,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_mapel($id)
    {
        $mapel = Mapel::where('id', $id)->first();

        $mapel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil di hapus',
        ]);
    }
}
