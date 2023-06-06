<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengumpulanController extends Controller
{
    public function pengumpulan()
    {
        $kelas_guru = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)->select('mapels.kelas_id')->get();

        $kelas = request ('kelas', null);
        $murid = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->whereIn('murids.kelas_id', $kelas_guru)
                        ->when($kelas, function ($query) use ($kelas){
                            return $query->whereHas('kelas', function ($query) use ($kelas) {
                                $query->where('id', $kelas);
                                });
                        })
                        ->get(['murids.nama_siswa', 'murids.email', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas']);
                        
        // if (count($murid) == 0) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Data tidak ada',
        //     ], 404);
        // }
        // else {
            return response()->json([
                "success" => true,
                "message" => "Pengumpulan",
                "pengumpulan" => $murid,
                // "kelas_guru" => $kelas_guru
            ], 200);
        // }
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
                                    ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
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

    public function konfirmasi($murid_id, $pengumpulan_id)
    {

        // $murid = Murid::find(3)->pengumpulans()->get();

        // return response()->json([
        //             "success" => true,
        //             "message" => "Pengumpulan",
        //             "murid" => $murid,
        //         ], 200);

        $pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', '=', auth()->user()->id)
        ->where('murids.id', '=', $murid_id)
        ->where('pengumpulans.id', '=', $pengumpulan_id)
        ->where('pengumpulans.status', '=', 'belum selesai')
        ->get('tugas.soal');

        return response()->json([
            "success" => true,
            "message" => "Pengumpulan",
            "pengumpulan" => $pengumpulan,
        ], 200);
    }
}
