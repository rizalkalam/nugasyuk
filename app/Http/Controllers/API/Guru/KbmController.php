<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KbmController extends Controller
{
    public function index()
    {
        $jurusan = request ('jurusan', null);
        $data_kelas = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->when($jurusan, function ($query) use ($jurusan){
                            return $query->whereHas('kelas', function ($query) use ($jurusan) {
                                $query->where('jurusan_id', $jurusan);
                                });
                        })
                        ->select(['kelas.id', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas'])
                        ->distinct()->get();



        return response()->json([
            "success" => true,
            "message" => "KBM",
            "kelas" => $data_kelas,
        ], 200);
    }

    public function materi($id)
    {
        // ada request query untuk guru yang memiliki 2 mapel
        $mapel = request ('mapel', null);
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                            ->where('kelas.id','=',$id)
                            ->when($mapel, function ($query) use ($mapel){
                                return $query->whereHas('mapel', function ($query) use ($mapel) {
                                    $query->where('id', $mapel);
                                });
                            })
                            ->where('gurus.id', auth()->user()->id)
                            ->select([
                                'materis.id',
                                'materis.nama_materi',
                                'gurus.nama_guru',
                                'materis.tanggal_dibuat'
                            ])->get();
        
        $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kelas.id', $kelas_id)
        ->select([
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas'
        ])
        ->first();

        $kelas = $data_kelas->tingkat_ke . ' ' . $data_kelas->nama_jurusan . ' ' . $data_kelas->nama_kelas;

        if (count($materi) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ada',
                'data' => $materi
            ], 404);
        }
        else {
            return response()->json([   
                "success" => true,
                "message" => "List Materi",
                "kelas" => $kelas,
                "materi" => $materi,
            ], 200);
        }
    }

    public function tugas($id)
    {
        // ada request query untuk guru yang memiliki 2 mapel
        $mapel = request ('mapel', null);
        $tugas = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
                        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('kelas.id', '=', $id)
                        ->where('gurus.id', auth()->user()->id)
                        ->when($mapel, function ($query) use ($mapel){
                            return $query->whereHas('mapel', function ($query) use ($mapel) {
                                $query->where('id', $mapel);
                            });
                        })
                        ->select([
                            'tugas.id',
                            'tugas.soal',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas', 
                        ])->get();

        if (count($tugas) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
                "tugas" => $tugas
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "List Tugas",
                "tugas" => $tugas,
            ], 200);
        }
    }

    public function detail_materi($id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                            ->where('gurus.id', '=', auth()->user()->id)
                            ->where('materis.id', '=', $id)
                            ->select(['materis.id', 'materis.nama_materi', 'gurus.nama_guru', 'materis.tanggal_dibuat', 'materis.isi', 'materis.link', 'materis.file'])->get();

        if (count($materi) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Detail Materi",
                "materi" => $materi,
            ], 200);
        }
    }

    public function detail_tugas($id)
    {
        $tugas = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
                        ->join('kodes','kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->where('tugas.id', '=', $id)
                        ->select([
                            'tugas.id',
                            'gurus.nama_guru',
                            'tugas.nama_tugas',
                            'tugas.soal',
                            'tugas.date',
                        ])->get();

        if (count($tugas) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Detail Tugas",
                "tugas" => $tugas,
            ], 200);
        }
    }

    public function cek_pengumpulan($id)
    {
        $data = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('tugas.id', $id)
        ->where('gurus.id', auth()->user()->id)
        ->select([
            'tugas.id',
            'tugas.nama_tugas',
            'gurus.nama_guru',
            'tugas.soal',
            'tugas.date',
            'tugas.deadline',
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "Cek Pengumpulan",
            "pengumpulan" => $data,
        ], 200);
    }

    public function pengumpulan_menunggu($id)
    {
         $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', '=', auth()->user()->id)
        ->where('tugas.id', '=', $id)
        ->where('pengumpulans.status', '=', 'menunggu')
        ->select([
            'murids.id',
            'murids.nama_siswa',
            'pengumpulans.status',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List siswa menunggu pengumpulan",
            "pengumpulan" => $data,
        ], 200);
    }

    public function pengumpulan_selesai($id)
    {
         $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', '=', auth()->user()->id)
        ->where('tugas.id', '=', $id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->select([
            'murids.id',
            'murids.nama_siswa',
            'pengumpulans.status',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List siswa selesai pengumpulan",
            "pengumpulan" => $data,
        ], 200);
    }

    public function buat_materi(Request $request, $id)
    {
         $validator = Validator::make($request->all(),[
             'nama_materi'=> 'required',
             'isi'=> 'required',
             'tahun_mulai'=> 'required',
             'tahun_selesai'=> 'required',
             'file'=> 'mimes:pdf,docx,xlsx|max:10000',
             // 'mapel_id'=> 'required',
             // 'tanggal_dibuat'=> 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                    'data' => [],
                ], 400);
            }

            $berkas = $request->file('file');
            $nama = $berkas->getClientOriginalName();

            $mapel_id = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('kelas_id', '=', $id)
            ->first();

            try {
                $materi = Materi::create([
                    'mapel_id'=> $mapel_id->id,
                    'nama_materi'=> $request->nama_materi,
                    'isi'=> $request->isi,
                    'tanggal_dibuat'=> Carbon::now()->format('Y-m-d'),
                    'tahun_mulai'=> $request->tahun_mulai,
                    'tahun_selesai'=> $request->tahun_selesai,
                    'file'=> $berkas->storeAs('file', $nama),
                ]);
        
                return response()->json([
                    'message' => 'Materi berhasil dibuat',
                    'data' => $materi,
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'failed',
                    'errors' => $th->getMessage(),
                ], 400);
            }
    
           
    }

    public function edit_materi(Request $request, $kelas_id, $mapel_id, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_materi'=> 'required',
            'isi'=> 'required',
            'tahun_mulai'=> 'required',
            'tahun_selesai'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('kelas_id', $kelas_id)
            ->where('mapels.id', $mapel_id)
            ->where('materis.id', $id)
            ->first('materis.id');

            $materi->update([
                'nama_materi'=> $request->nama_materi,
                'isi'=> $request->isi,
                'tahun_mulai'=> $request->tahun_mulai,
                'tahun_selesai'=> $request->tahun_selesai,
            ]);

            return response()->json([
                'message' => 'test',
                'data' => $materi,
            ]);
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_materi($kelas_id, $mapel_id, $id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('kelas_id', $kelas_id)
            ->where('mapels.id', $mapel_id)
            ->where('materis.id', $id)
            ->first('materis.id');
        
        $materi->delete();

        return response()->json([
            'success' => true,
            'message' => 'materi berhasil di hapus',
        ]);
    }

    public function buat_tugas(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_tugas'=> 'required',
            'soal'=> 'required',
            'description'=> 'required',
            'deadline'=> 'required'
            // 'mapel_id'=> 'required',
            // 'date'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ], 400);
        }

        try {
            $mapel = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
                        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->where('kodes.guru_id', '=', auth()->user()->id)
                        ->where('kelas_id', '=', $id)
                        ->get();
            
            if (!$mapel->isEmpty()) {
        
                $tugas = Tugas::create([
                    'mapel_id'=> $mapel->first()->id,
                    'nama_tugas'=> $request->nama_tugas,
                    'soal'=> $request->soal,
                    'description'=> $request->description,
                    'date'=> Carbon::now()->format('Y-m-d'),
                    'deadline'=> $request->deadline,
                ]);
    
                $tugasId = Tugas::latest()->first()->id;
    
                $muridId = Murid::where('kelas_id', $id)
                ->get();
    
                $data = [];
                foreach ($muridId as $id) {
                    $data[] = [
                        'tugas_id' => $tugasId,
                        'murid_id' => $id->id,
                        'tanggal' => Carbon::now()->format('Y-m-d')
                    ];
                }
                
                $pengumpulan = Pengumpulan::insert($data);
        
                return response()->json([
                    'message' => 'Tugas berhasil dibuat',
                    'tugas' => $tugas,
                ]);
               
            } else {

                return response()->json([
                    'pesan' => 'Tugas gagal dibuat',
                    'data' => 'error',
                ]);
    
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }

        
    }

    public function edit_tugas(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_tugas'=> 'required',
            'soal'=> 'required',
            'description'=> 'required',
            'deadline'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        try {
            $tugas =  Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
            ->join('kodes','kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
            ->where('gurus.id', '=', auth()->user()->id)
            ->where('tugas.id', '=', $id)
            ->first('tugas.id');
            
            $tugas->update([
                'nama_tugas'=> $request->nama_tugas,
                'soal'=> $request->soal,
                'description'=> $request->description,
                'deadline'=> $request->deadline
            ]);

            return response()->json([
                'message' => 'test',
                'data' => $tugas,
            ]);
                            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ]);
        }
    }

    public function hapus_tugas($kelas_id, $tugas_id)
    {
        $tugas = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('kelas_id', $kelas_id)
            ->where('tugas.id', $tugas_id)
            ->first('tugas.id');
        
            $tugas->delete();
            $pengumpulan = Pengumpulan::where('tugas_id', $tugas_id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'tugas berhasil di hapus',
            ]);
    }
}
