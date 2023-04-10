<?php

namespace App\Http\Controllers\API;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $tugasall = Tugas::all();
        foreach ($tugasall as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $tugas[]=[
                    'judul'=>$item->judul,
                    'status'=>$item->status
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
        $mapels = Mapel::all();
        foreach ($mapels as $mapel) {
            if ($mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                $kelas[]=[
                    'id'=>$mapel->kelas->id,
                    'kelas'=>$mapel->kelas->tingkatan->tingkat_ke . ' ' . $mapel->kelas->jurusan->nama_jurusan . ' ' . $mapel->kelas->nama_kelas
                ];
            }    
        }

        return response()->json([
            "success" => true,
            "message" => "KBM",
            "kelas" => $kelas,
        ], 200);
    }

    public function materi($key)
    {
        $materis = Materi::all();
        foreach ($materis as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                if ($item->mapel->kelas->id == $key) {
                    $materi[]=[
                        'kelas'=>$item->mapel->kelas->tingkatan->tingkat_ke . ' ' . $item->mapel->kelas->jurusan->nama_jurusan . ' ' . $item->mapel->kelas->nama_kelas,
                        'judul'=>$item->judul
                    ];
                }
            }
        }

        if (!empty($materi)) {
            return response()->json([
                "success" => true,
                "message" => "List Materi",
                "materi" => $materi,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Materi tidak ada',
        ], 404);
    }

    public function tugas($key)
    {
        $all_tugas = Tugas::all();
        foreach ($all_tugas as $item){
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                if ($item->mapel->kelas->id == $key) {
                    $tugas[]=[
                        'kelas'=>$item->mapel->kelas->tingkatan->tingkat_ke . ' ' . $item->mapel->kelas->jurusan->nama_jurusan . ' ' . $item->mapel->kelas->nama_kelas,
                        'judul'=>$item->judul
                    ];
                }
            }
            
            if (!empty($tugas)) {
                return response()->json([
                    "success" => true,
                    "message" => "List Tugas",
                    "tugas" => $tugas,
                ], 200);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
            ], 404);
        }
    }

    public function detail_materi($kelas_id, $materi_id)
    {
        $materis = Materi::all();
        foreach ($materis as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                if ($item->mapel->kelas->id == $kelas_id) {
                   if ($item->id == $materi_id) {
                    $materi[]=[
                        'judul'=>$item->judul,
                        'nama_guru'=>$item->mapel->kode->guru->nama_guru,
                        'tanggal'=>$item->date,
                        'isi'=>$item->isi,
                        'link'=>$item->link,
                        'file'=>$item->file
                    ];
                   }
                }
            }
        }

        if (!empty($materi)) {
            return response()->json([
                "success" => true,
                "message" => "KBM",
                "materi" => $materi,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Materi tidak ada',
        ], 404);
    }

    public function detail_tugas($kelas_id, $tugas_id)
    {
        $all_tugas = Tugas::all();
        foreach ($all_tugas as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                if ($item->mapel->kelas->id == $kelas_id) {
                   if ($item->id == $tugas_id) {
                    $tugas[]=[
                        'judul'=>$item->judul,
                        'nama_guru'=>$item->mapel->kode->guru->nama_guru,
                        'tanggal'=>$item->date,
                        'deskripsi'=>$item->description,
                    ];
                   }
                }
            }
        }

        if (!empty($tugas)) {
            return response()->json([
                "success" => true,
                "message" => "KBM",
                "tugas" => $tugas,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tugas tidak ada',
        ], 404);
    }

    public function cek_pengumpulan($kelas_id, $tugas_id)
    {
        $all_tugas = Tugas::all();
        foreach ($all_tugas as $item) {
            if ($item->mapel->kode->guru->nama_guru == auth()->user()->nama_guru) {
                if ($item->mapel->kelas->id == $kelas_id) {
                   if ($item->id == $tugas_id) {
                    $tugas[]=[
                        'judul'=>$item->judul,
                        'nama_guru'=>$item->mapel->kode->guru->nama_guru,
                        'tanggal'=>$item->date,
                        'deskripsi'=>$item->description,
                    ];
                   }
                }
            }
        }
       
        // $murids = Murid::all();
        // foreach ($murids as $item) {
        //     if ($item->tugas->mapel_id == auth()->user()->mapel->id) {
        //         if ($item->tugas->mapel_id == $key) {
        //             $tugas[]=[
        //                 'nama_siswa'=>$item->nama_siswa,
        //                 'judul'=>$item->tugas->judul,
        //                 'status'=>$item->tugas->status,
        //                 // 'nama_guru'=>$item->mapel->kode->guru->nama_guru,
        //                 // 'tanggal'=>$item->date,
        //                 // 'deskripsi'=>$item->description,
        //                 // 'menunggu'=>$item->status,
        //                 // 'selesai'=>$item->status
        //             ];
        //         }
        //     }
        // }

        if (!empty($tugas)) {
            return response()->json([
                "success" => true,
                "message" => "Checklist Pengumpulan Tugas",
                "tugas" => $tugas,
                // "status" => $status
                // "tes"=>$key
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tugas tidak ada',
            // 'data'    => ''
        ], 404);
    }
}
