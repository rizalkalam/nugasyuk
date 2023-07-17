<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Percakapan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            'mapels.kelas_id',
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $data = Mapel::create([
            'kode_id' => $request->kode_id,
            'kelas_id' => $request->kelas_id,
            'asset_id' => $request->asset_id,
        ]);

        $mapel = Mapel::latest()->first();

        $guru = Kode::where('id', $mapel->kode_id)->first();

        if ($mapel->kode->status_mapel == 'bk') {
            $murid = Murid::where('kelas_id', $mapel->kelas_id)
            ->get();

            $percakapan = [];
            foreach ($murid as $id) {
                $percakapan[] = [
                    'user_one' => $guru->guru_id,
                    'user_two' => $id->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
            }

            $new_percakapan = Percakapan::insert($percakapan);
        }

        return response()->json([
            'message' => 'Data Mata Pelajaran baru berhasil dibuat',
            'data' => $data,
            // 'mapel' => $mapel
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
            $data = Mapel::where('id', $id)->first();

            $data->update([
                'kode_id' => $request->kode_id,
                'kelas_id' => $request->kelas_id,
                'asset_id' => $request->asset_id,
            ]);

            $mapel = Mapel::latest()->first();

            $guru = Kode::where('id', $mapel->kode_id)->first();

            if ($mapel->kode->status_mapel == 'bk') {

                $old_percakapan = Percakapan::whereIn('user_one', '=', $guru)->delete();

                $murid = Murid::where('kelas_id', $mapel->kelas_id)
                ->get();

    
                $percakapan = [];
                foreach ($murid as $id) {
                    $percakapan[] = [
                        'user_one' => $guru,
                        'user_two' => $id->id,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ];
                }
    
                Percakapan::insert($percakapan);
            }

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

    public function detail_mapel($id)
    {
        $data = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('mapels.id', $id)
        ->select([
            'mapels.id',
            'kodes.nama_mapel',
            'gurus.nama_guru',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'assets.file_asset'
        ])->first();

        $kode_id = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('mapels.id', $id)->value('kodes.id');

        $kelas_id = Mapel::join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->where('mapels.id', $id)->value('kelas.id');

        $asset_id =  Mapel::join('assets', 'assets.id', '=', 'mapels.asset_id')
        ->where('mapels.id', $id)->value('assets.id');

        $data = [
            "id"=>$data->id,
            "nama_mapel"=>$data->nama_mapel,
            "nama_guru"=>$data->nama_guru,
            "tingkat_ke"=>$data->tingkat_ke,
            "nama_jurusan"=>$data->nama_jurusan,
            "nama_kelas"=>$data->nama_kelas,
            "file_asset"=>$data->file_asset,
            "kode_id"=>$kode_id,
            "kelas_id"=>$kelas_id,
            "asset_id"=>$asset_id
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Mata Pelajaran",
            "data" => $data,
        ], 200);
    }
}
