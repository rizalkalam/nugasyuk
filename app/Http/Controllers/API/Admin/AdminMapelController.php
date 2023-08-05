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
use App\Http\Resources\AdminListMapelResource;

class AdminMapelController extends Controller
{
    public function index()
    {
        $nama_mapel = request('nama_mapel', null);
        $jurusan = request('jurusan', null);
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->leftjoin('assets', 'assets.id', '=', 'mapels.asset_id')
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

        $data = AdminListMapelResource::collection($mapel);

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

        $data_mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kodes.id', $request->kode_id)
        ->where('kelas.id', $request->kelas_id)
        ->select([
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'kodes.nama_mapel'
        ])
        ->first();

        if (empty($data_mapel)) {
         
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
            
        } else {
            return response()->json([
                'message' => 'Data Mata Pelajaran sudah ada',
                // 'data' => $kelas_lama,
            ], 400);
        }
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
            $data = Mapel::join('assets', 'assets.id', 'mapels.asset_id')
            ->where('mapels.id', $id)
            ->first();

            $kelas_cek = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kelas.id', $request->kelas_id)
            ->select([
                'kodes.nama_mapel'
            ])->get();

            $kode_lama = Mapel::where('mapels.id', $id)
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->select([
                'tingkatans.tingkat_ke',
                'jurusans.nama_jurusan',
                'kelas.nama_kelas',
                'kodes.nama_mapel'
            ])
            ->first();

            $kode_baru = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->where('kodes.id', $request->kode_id)
            ->where('kelas.id', $request->kelas_id)
            ->select([
                'tingkatans.tingkat_ke',
                'jurusans.nama_jurusan',
                'kelas.nama_kelas',
                'kodes.nama_mapel'
            ])
            ->first();

            if (empty($kode_baru)) {

                $data->update([
                    'kode_id' => $request->kode_id,
                    'kelas_id' => $request->kelas_id,
                    'asset_id' => $request->asset_id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $mapel = Mapel::orderBy('updated_at','DESC')->first();

                $guru = Kode::where('id', $mapel->kode_id)->first();

                if ($mapel->kode->status_mapel == 'bk') {

                    $data_percakapan = Percakapan::whereIn('user_one', array($guru->guru_id))->delete();

                    $murid = Murid::where('kelas_id', $request->kelas_id)
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
        
                    Percakapan::insert($percakapan);
                }

                return response()->json([
                    'message' => 'Data Mata Pelajaran berhasil di ubah',
                    // 'data' => $mapel,
                ]);$data->update([
                    'kode_id' => $request->kode_id,
                    'kelas_id' => $request->kelas_id,
                    'asset_id' => $request->asset_id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $mapel = Mapel::orderBy('updated_at','DESC')->first();

                $guru = Kode::where('id', $mapel->kode_id)->first();

                if ($mapel->kode->status_mapel == 'bk') {

                    $data_percakapan = Percakapan::whereIn('user_one', array($guru->guru_id))->delete();

                    $murid = Murid::where('kelas_id', $request->kelas_id)
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
        
                    Percakapan::insert($percakapan);
                }

                return response()->json([
                    'message' => 'Data Mata Pelajaran berhasil di ubah',
                    // 'data' => $mapel,
                ]);

            } else if (!empty($kelas_cek)) {

                return response()->json([
                    'message' => 'Data Mapel sudah ada',
                    'mapel' => $kode_lama,
                    // 'data2' => $kode_baru,
                    // 'data3' => $kelas_cek
                ], 400);
                
    
            } else {

                $data->update([
                    'kode_id' => $request->kode_id,
                    'kelas_id' => $request->kelas_id,
                    'asset_id' => $request->asset_id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                $mapel = Mapel::orderBy('updated_at','DESC')->first();

                $guru = Kode::where('id', $mapel->kode_id)->first();

                if ($mapel->kode->status_mapel == 'bk') {

                    $data_percakapan = Percakapan::whereIn('user_one', array($guru->guru_id))->delete();

                    $murid = Murid::where('kelas_id', $request->kelas_id)
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
        
                    Percakapan::insert($percakapan);
                }

                return response()->json([
                    'message' => 'Data Mata Pelajaran berhasil di ubah',
                    // 'data' => $mapel,
                ]);

            }

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
        $guru = Kode::where('id', $mapel->kode_id)->first();

        $mapel->delete();

        if ($mapel->kode->status_mapel == 'bk') {
            $data_percakapan = Percakapan::whereIn('user_one', array($guru->guru_id))->delete();
            $mapel->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data jadwal berhasil di hapus',
        ]);
    }

    public function detail_mapel($id)
    {
        $data = Mapel::leftjoin('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->leftjoin('assets', 'assets.id', '=', 'mapels.asset_id')
        ->leftjoin('gurus', 'gurus.id', '=', 'kodes.guru_id')
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
            "nama_mapel"=>$data->nama_mapel !== null ? $data->nama_mapel : 0,
            "nama_guru"=>$data->nama_guru !== null ? $data->nama_guru : 0,
            "tingkat_ke"=>$data->tingkat_ke,
            "nama_jurusan"=>$data->nama_jurusan,
            "nama_kelas"=>$data->nama_kelas,
            "file_asset"=>$data->file_asset !== null ? $data->file_asset : 0,
            "kode_id"=>$kode_id !== null ? $kode_id : 0,
            "kelas_id"=>$kelas_id,
            "asset_id"=>$asset_id !== null ? $asset_id : 0
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Mata Pelajaran",
            "data" => $data,
        ], 200);
    }
}
