<?php

namespace App\Http\Controllers\API;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Soal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Status;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function beranda()
    {
        $profile = array();
        $profile[]=[
            'nama_guru'=>auth()->user()->nama_guru,
            'foto_profile'=>auth()->user()->foto_profile,
        ];

        // mapel guru
        $kode = Kode::all();
        foreach ($kode as $item) {
            if ($item->guru->nama_guru == auth()->user()->nama_guru) {
               $mata_pelajaran[]=[
                'mapel_guru'=>$item->nama_mapel
               ];
            }
        }

        // jumlah kelas yang diajar
        $mapels = Mapel::all();
        foreach ($mapels as $mapel) {
            if ($mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $kelas[]=[
                    'kelas'=>$mapel->kelas->tingkatan->tingkat_ke . ' ' . $mapel->kelas->jurusan->nama_jurusan . ' ' . $mapel->kelas->nama_kelas
                ];
            }
        }

        // jumlah materi yang diberikan
        $materis = Materi::all();
        foreach ($materis as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $materi[]=[
                    'judul'=>$item->judul
                ];
            }
        }

        // jumlah tugas yang diberikan
        $all_tugas = Tugas::all();
        foreach ($all_tugas as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $tugas[]=[
                    'judul'=>$item->soal,
                ];
            }
        }

        return response()->json([
            "success" => true,
            "message" => "Beranda Guru",
            "profile_guru" => $profile,
            "mapel_guru"=>$mata_pelajaran,
            "mengajar"=>$kelas,
            "materi_diberikan"=>$materi,
            "tugas_diberikan"=>$tugas
        ], 200);
    }

    public function profile()
    {
        $profile = array();
        $profile[]=[
            'foto_profile'=>auth()->user()->foto_profile,
            'email'=>auth()->user()->email,
            'nama_guru'=>auth()->user()->nama_guru,
            'mapel_guru'=>auth()->user()->mapel->kode->nama_mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Profile Guru",
            "profile_guru" => $profile,
        ], 200);
    }

    public function kbm()
    {
        $kelas = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->get(['tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas']);

        return response()->json([
            "success" => true,
            "message" => "KBM",
            "kelas" => $kelas,
        ], 200);
    }

    public function materi($kelas_id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                            ->where('gurus.id', '=', auth()->user()->id)
                            ->where('kelas.id','=',$kelas_id)
                            ->get('materis.nama_materi');

        if (count($materi) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "List Materi",
                "materi" => $materi,
            ], 200);
        }
        
    }

    public function tugas($kelas_id)
    {
        $tugas = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
                        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->where('kelas.id', '=', $kelas_id)
                        ->get([
                            'tugas.id',
                            'tugas.soal',
                            'materis.nama_materi',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas', 
                        ]);

        if (count($tugas) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
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

    public function detail_materi($kelas_id, $materi_id)
    {
        $materi = Materi::join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                            ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                            ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                            ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                            ->where('gurus.id', '=', auth()->user()->id)
                            ->where('kelas.id', '=', $kelas_id)
                            ->where('materis.id', '=', $materi_id)
                            ->get(['materis.nama_materi', 'gurus.nama_guru', 'materis.date', 'materis.isi', 'materis.link', 'materis.file']);

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

    public function detail_tugas($kelas_id, $tugas_id)
    {
        $tugas = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
                        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                        ->join('kodes','kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->where('kelas.id', '=', $kelas_id)
                        ->where('tugas.id', '=', $tugas_id)
                        ->get([
                            'tugas.soal',
                            'gurus.nama_guru',
                            'tugas.date',
                            'tugas.description'
                        ]);

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

    public function cek_pengumpulan($kelas_id, $tugas_id, $status)
    {
        $pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
                                    ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
                                    ->join('materis', 'materis.id', '=', 'tugas.materi_id')
                                    ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                                    ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                                    ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                                    ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                                    ->where('gurus.id', '=', auth()->user()->id)
                                    ->where('kelas.id', '=', $kelas_id)
                                    ->where('tugas.id', '=', $tugas_id)
                                    ->where('pengumpulans.status', '=', $status)
                                    ->get([
                                        'murids.nama_siswa',
                                        'pengumpulans.status'
                                    ]);

            if (count($pengumpulan) == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tugas tidak ada',
                ], 404);
            }
            else {
                return response()->json([
                    "success" => true,
                    "message" => "Detail Pengumpulan",
                    "pengumpulan" => $pengumpulan,
                ], 200);
            }
    }

    public function pengumpulan($kelas_id = '1')
    {
        $murid = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('kelas.id', '=', $kelas_id)
                        ->filter(request(['search']))
                        ->get(['murids.nama_siswa', 'murids.email', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas']);
                        
        if (count($murid) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Pengumpulan",
                "pengumpulan" => $murid,
            ], 200);
        }
    }

    public function detail_pengumpulan($nama)
    {
        $murid = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('murids.nama_siswa', '=', $nama)
                        ->get(['murids.nama_siswa', 'murids.email', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas']);

        if (count($murid) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Pengumpulan",
                "pengumpulan" => $murid,
            ], 200);
        }
    }

    public function status_pengumpulan($nama, $status)
    {
        $pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
                                    ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
                                    ->join('materis', 'materis.id', '=', 'tugas.materi_id')
                                    ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
                                    ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                                    ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                                    ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                                    ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                                    ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                                    ->where('gurus.id', '=', auth()->user()->id)
                                    ->where('murids.nama_siswa', '=', $nama)
                                    ->where('pengumpulans.status', '=', $status)
                                    ->get(['tugas.soal', 'gurus.nama_guru', 'tugas.deadline', 'tugas.created_at', 'pengumpulans.status']);

        if (count($pengumpulan) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada',
            ], 404);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Pengumpulan",
                "pengumpulan" => $pengumpulan,
            ], 200);
        }
    }

    public function buat_materi(Request $request, $kelas_id, $nama_mapel)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->where('kodes.guru_id', '=', auth()->user()->id)
        ->where('kelas_id', $kelas_id)
        ->where('kodes.nama_mapel', $nama_mapel)
        ->get('mapels.id');

         $validator = Validator::make($request->all(),[
                'mapel_id'=> 'required',
                'nama_materi'=> 'required',
                'isi'=> 'required',
                // 'link'=> 'required',
                // 'file'=> 'required',
                // 'tahun'=> 'required',
            ]);
    
            $materi = Materi::create([
                'mapel_id'=> $mapel->first()->id,
                'nama_materi'=> $request->nama_materi,
                'isi'=> $request->isi,
                // 'link'=> $request->link,
                // 'file'=> $request->file,
                // 'tahun'=> $request->tahun
            ]);
    
            return response()->json([
                'message' => 'Materi berhasil dibuat',
                'data' => $materi,
            ]);
    }

    public function buat_tugas(Request $request, $kelas_id, $nama_mapel)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->where('kodes.guru_id', '=', auth()->user()->id)
                        ->where('kelas_id', '=', $kelas_id)
                        ->where('kodes.nama_mapel', '=', $nama_mapel)
                        ->get('mapels.id');

                        // return response()->json([
                        //     'message' => 'Tugas berhasil dibuat',
                        //     'data' => $mapel->first()->id,
                        // ]);

        if (!$mapel->isEmpty()) {
            $validator = Validator::make($request->all(),[
                'materi_id'=> 'required',
                'soal'=> 'required',
                // 'date'=> 'required',
                // 'deadline'=> 'required',
                'description'=> 'required',
                // 'link'=> 'required',
                // 'file'=> 'required'
            ]);
    
            $tugas = Tugas::create([
                'materi_id'=> $request->materi_id,
                'soal'=> $request->soal,
                // 'date'=> 'required',
                // 'deadline'=> 'required',
                'description'=> $request->description,
                // 'link'=> 'required',
                // 'file'=> 'required'
            ]);
    
            return response()->json([
                'message' => 'Tugas berhasil dibuat',
                'data' => $tugas,
            ]);
           
        } else {
            return response()->json([
                'message' => 'Tugas gagal dibuat',
                'data' => 'error',
            ]);

        }
    }
}
