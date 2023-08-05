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
use App\Http\Resources\DetailTugasResource;
use App\Http\Resources\DetailTugasKbmResource;
use App\Http\Resources\GuruDetailTugasResource;

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
                                'mapels.kelas_id',
                                'materis.nama_materi',
                                'gurus.nama_guru',
                                'materis.tanggal_dibuat'
                            ])->get();
        
        $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kelas.id', $id)
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
            ], 200);
        }
        else {
            return response()->json([   
                "success" => true,
                "message" => "List Materi",
                "kelas" => $kelas,
                "kelas_id" => $materi->first()->kelas_id,
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
                            'mapels.kelas_id',
                            'tugas.soal',
                            'tugas.date',
                            'tugas.deadline',
                            'gurus.nama_guru',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas', 
                        ])->get();

        $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kelas.id', $id)
        ->select([
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas'
        ])
        ->first();

        $kelas = $data_kelas->tingkat_ke . ' ' . $data_kelas->nama_jurusan . ' ' . $data_kelas->nama_kelas;

        if (count($tugas) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
                "tugas" => $tugas
            ], 200);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "List Tugas",
                "kelas" => $kelas,
                "kelas_id" => $tugas->first()->kelas_id,
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
                            ->select([
                                'materis.id',
                                'mapels.kelas_id',
                                'materis.nama_materi',
                                'gurus.nama_guru',
                                'materis.tanggal_dibuat',
                                'materis.isi',
                                'materis.link',
                                'materis.file'
                            ])->first();

                            $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                            ->where('kelas.id', $materi->kelas_id)
                            ->select([
                                'tingkatans.tingkat_ke',
                                'jurusans.nama_jurusan',
                                'kelas.nama_kelas'
                            ])
                            ->first();
                    
                            $kelas = $data_kelas->tingkat_ke . ' ' . $data_kelas->nama_jurusan . ' ' . $data_kelas->nama_kelas;
        
        $data = [
            "id" => $materi->id,
            "nama_materi" => $materi->nama_materi,
            "nama_guru" => $materi->nama_guru,
            "tanggal_dibuat" => $materi->tanggal_dibuat,
            "isi" => $materi->isi,
            "link" => $materi->link !== null ? $materi->link : 0,
            "file" => $materi->file !== null ? $materi->file : 0
        ];

        if (empty($materi)) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Detail Materi",
                "kelas" => $kelas,
                "materi" => $data,
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
                            'mapels.kelas_id',
                            'gurus.nama_guru',
                            'tugas.nama_tugas',
                            'tugas.soal',
                            'tugas.date',
                            'tugas.deadline',
                            'tugas.link_tugas',
                            'tugas.file_tugas'
                        ])->get();

                        $data_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                            ->where('kelas.id', $tugas->first()->kelas_id)
                            ->select([
                                'tingkatans.tingkat_ke',
                                'jurusans.nama_jurusan',
                                'kelas.nama_kelas'
                            ])
                            ->first();
                    
                        $kelas = $data_kelas->tingkat_ke . ' ' . $data_kelas->nama_jurusan . ' ' . $data_kelas->nama_kelas;

        $data = DetailTugasKbmResource::collection($tugas);

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
                "kelas" => $kelas,
                "tugas" => $data,
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
            'murids.email',
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
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', '=', auth()->user()->id)
        ->where('tugas.id', '=', $id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->select([
            'murids.id',
            'murids.nama_siswa',
            'murids.email',
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

    public function buat_materi(Request $request, $kelas_id)
    {
         $validator = Validator::make($request->all(),[
             'judul'=> 'required',
             'deskripsi'=> 'required',
             'link'=> 'nullable',
             'file'=> 'max:10000|nullable',
            //  'tahun_mulai'=> 'required',
            //  'tahun_selesai'=> 'required',
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

            $mapel_id = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('mapels.kelas_id', '=', $kelas_id)
            ->first('mapels.id');

            try {

                if ($request->hasFile('file')) {
                    $berkas = $request->file('file');
                    $data_cek = time().'-'.$berkas->getClientOriginalName();
                    $data_file = $berkas->storeAs('file', $data_cek);
                }else{
                    $data_file = null;
                }
                // $berkas = $request->file('file');
                // $nama = $berkas->getClientOriginalName();

                $materi = Materi::create([
                    'mapel_id'=> $mapel_id->id,
                    'nama_materi'=> $request->judul,
                    'isi'=> $request->deskripsi,
                    'tanggal_dibuat'=> Carbon::now()->format('Y-m-d'),
                    'file'=> $data_file,
                    'link'=> $request->link
                    // 'tahun_mulai'=> $request->tahun_mulai,
                    // 'tahun_selesai'=> $request->tahun_selesai,
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

    public function edit_materi(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'judul'=> 'required',
            'deskripsi'=> 'required',
            'file'=> 'max:10000|nullable',
            'link'=> 'nullable',
            // 'tahun_mulai'=> 'required',
            // 'tahun_selesai'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $file_path = Materi::where('id', $id)->value('file');

        if ($request->hasFile('file')) {
            if (!empty($file_path)) {
                Storage::delete($file_path);
            }
            $berkas = $request->file('file');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('file', $nama);
        } else {
            $edit = $file_path;
        }

        try {
            $materi = Materi::where('id', '=', $id)
            ->first();

            $materi->update([
                'nama_materi'=> $request->judul,
                'isi'=> $request->deskripsi,
                'link'=> $request->link,
                'file' => $edit
                // 'tahun_mulai'=> $request->tahun_mulai,
                // 'tahun_selesai'=> $request->tahun_selesai,
            ]);

            return response()->json([
                'message' => 'Materi berhasil diedit',
                'data' => $materi,
            ], 200);
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage(),
            ], 400);
        }
    }

    public function hapus_materi($id)
    {
        $materi = Materi::where('id', $id)
            ->first('id');

        $file_path = Materi::where('id', $id)->value('file');

        if (!empty($file_path)) {
            Storage::delete($file_path);
        }
        
        $materi->delete();

        return response()->json([
            'success' => true,
            'message' => 'materi berhasil di hapus',
        ]);
    }

    public function buat_tugas(Request $request, $kelas_id)
    {
        $validator = Validator::make($request->all(),[
            'judul_tugas'=> 'required',
            'tugas'=> 'required',
            'deadline'=> 'required',
            'link'=> 'nullable',
            'file'=> 'max:10000|nullable',
            'input_jawaban'=> 'required'
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

        if ($request->hasFile('file')) {
            $berkas = $request->file('file');
            $data_cek = time().'-'.$berkas->getClientOriginalName();
            $data_file = $berkas->storeAs('file', $data_cek);
        }else{
            $data_file = null;
        }
        
        try {
            // $berkas = $request->file('file');
            // $nama = $berkas->getClientOriginalName();

            $mapel_id = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
            ->where('kodes.guru_id', '=', auth()->user()->id)
            ->where('mapels.kelas_id', '=', $kelas_id)
            ->first('mapels.id');
        
                $tugas = Tugas::create([
                    'mapel_id'=> $mapel_id->id,
                    'nama_tugas'=> $request->judul_tugas,
                    'soal'=> $request->tugas,
                    'deadline'=> $request->deadline,
                    'date'=>Carbon::now()->format('Y-m-d'),
                    'link_tugas'=> $request->link,
                    'file_tugas'=> $data_file,
                    'input_jawban'=> $request->input_jawaban
                ]);
    
                $tugasId = Tugas::latest()->first()->id;
    
                $muridId = Murid::where('kelas_id', $kelas_id)
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

                return response()->json([
                    'message' => 'Tugas gagal dibuat',
                    'data' => 'error',
                ]);

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
            'judul_tugas'=> 'required',
            'tugas'=> 'required',
            'deadline'=> 'required',
            'file'=> 'max:10000|nullable',
            'link'=> 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => [],
            ]);
        }

        $file_path = Tugas::where('id', $id)->value('file_tugas');

        if ($request->hasFile('file')) {
            if (!empty($file_path)) {
                Storage::delete($file_path);
            }
            $berkas = $request->file('file');
            $nama = time().'-'.$berkas->getClientOriginalName();
            $edit = $berkas->storeAs('file', $nama);
        } else {
            $edit = $file_path;
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
                'nama_tugas'=> $request->judul_tugas,
                'soal'=> $request->tugas,
                'description'=> $request->description,
                'deadline'=> $request->deadline,
                'link_tugas'=> $request->link,
                'file_tugas'=> $edit,
                'input_jawaban'=> $request->input_jawaban
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

    public function hapus_tugas($id)
    {
        $tugas = Tugas::where('id', $id)
            ->first('tugas.id');
        
            $tugas->delete();
            $pengumpulan = Pengumpulan::where('tugas_id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'tugas berhasil di hapus',
            ]);
    }
}
