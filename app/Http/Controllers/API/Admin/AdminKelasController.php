<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Jadwal;
use App\Models\Jurusan;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        ->orderBy('kelas.nama_kelas', 'ASC')
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
        ->leftjoin('gurus', 'gurus.id', '=', 'kelas.guru_id')
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
            'wali_kelas'=>$kelas->nama_guru !== null ? $kelas->nama_guru : 0,
            'tingkatan_id'=>$tinkgatan_id,
            'jurusan_id'=>$jurusan_id,
            'guru_id'=>$guru_id !== null ? $guru_id : 0
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

        $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->leftjoin('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('tingkatans.id', $request->tingkatan)
        ->where('jurusans.id', $request->jurusan)
        ->where('kelas.nama_kelas',  $request->nama_kelas)
        ->select([
            'kelas.id',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
            'gurus.nama_guru',
        ])->first();


        if (empty($data_kelas)) {

            $data = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'guru_id' => $request->wali_kelas,
                'jurusan_id' => $request->jurusan,
                'tingkatan_id' => $request->tingkatan,
            ]);
    
            return response()->json([
                'message' => 'Data Kelas baru berhasil dibuat',
                'data' => $data,
            ], 200);
            
        } else {
            return response()->json([
                'message' => 'Data Kelas sudah ada',
                'data' => $kelas_lama,
            ], 400);
        }
        
    }

    public function edit_kelas(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'wali_kelas' => 'required',
            'nama_kelas' => 'required',
            'jurusan' => 'required',
            'tingkatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ],400);
        }

        try {

            $kelas_pilih = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->join('gurus', 'gurus.id', '=', 'kelas.guru_id')
            ->where('kelas.id', $id)
            ->select([
                'kelas.id',
                'tingkatans.tingkat_ke',
                'jurusans.nama_jurusan',
                'kelas.nama_kelas',
                // 'gurus.nama_guru',
            ])->first();

            $kelas_edit = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->leftjoin('gurus', 'gurus.id', '=', 'kelas.guru_id')
            ->where('tingkatans.id', $request->tingkatan)
            ->where('jurusans.id', $request->jurusan)
            ->where('kelas.nama_kelas',  $request->nama_kelas)
            ->select([
                'kelas.id',
                'tingkatans.tingkat_ke',
                'jurusans.nama_jurusan',
                'kelas.nama_kelas',
                // 'gurus.nama_guru',
            ])->first();

            if ($kelas_edit == $kelas_pilih) {

                $kelas = Kelas::where('id', $id)->first();
    
                $kelas->update([
                    'nama_kelas' => $request->nama_kelas,
                    'guru_id' => $request->wali_kelas,
                    'jurusan_id' => $request->jurusan,
                    'tingkatan_id' => $request->tingkatan,
                ]);

                return response()->json([
                    'message' => 'Data Kelas berhasil di ubah',
                    'data' => $kelas
                ], 200);

            } elseif (!empty($kelas_edit)){

                return response()->json([
                    'message' => 'Data kelas belum di buat',
                    'data' => $kelas_edit
                 ], 400);

            } else {

                return response()->json([
                   'message' => 'Data kelas sudah ada',
                   'data' => $kelas_edit
                ], 400);

            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ]);
        }

       
    }

    public function hapus_kelas($id)
    {   
        Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->where('mapels.kelas_id', $id)->delete();

        Mapel::where('kelas_id', $id)->delete();

        Kelas::where('id', $id)->delete();


        return response()->json([
            'success' => true,
            'message' => 'Data kelas berhasil di hapus',
        ]);
    }
}
