<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
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
                        ->orderBy('murids.nama_siswa', 'ASC')
                        ->get(['murids.id', 'murids.kelas_id',  'murids.foto_profile', 'murids.nama_siswa', 'murids.email', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas']);
                        
        $jumlah_murid = count($murid);
    
        return response()->json([
            "success" => true,
            "message" => "list siswa",
            "jumlah_siswa" => $jumlah_murid,
            "pengumpulan" => $murid,
        ], 200);
    }

    public function detail_pengumpulan($id)
    {
        $tugas = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
                        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
                        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
                        ->join('kodes','kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->where('murids.id', '=', $id)
                        ->select([
                            'pengumpulans.tugas_id',
                            'pengumpulans.murid_id',
                            'murids.nama_siswa',
                            'murids.email',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas',
                            'tugas.nama_tugas',
                            'tugas.soal',
                            'tugas.date',
                            'pengumpulans.status',
                            'pengumpulans.file',
                            'pengumpulans.link',
                        ])->first();

        if (empty($tugas)) {
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

    public function konfirmasi($id)
    {
        $pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', '=', auth()->user()->id)
        ->where('murids.id', '=', $id)
        ->where('pengumpulans.status', '=', 'menunggu')
        ->first();

        if (!empty($pengumpulan)) {
            $status = Pengumpulan::join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
            ->where('murids.id', $id)
            ->update(['status'=>'selesai']);

            return response()->json([
                "success" => true,
                "message" => "Pengumpulan berhasil dikonfirmasi",
                "pengumpulan" => Pengumpulan::where('id', $id)->first(),
            ], 200);
        }else {
            return response()->json([
                "success" => true,
                "message" => "Tidak ada data",
                "pengumpulan" => $pengumpulan,
            ], 400);
        }

    }

    public function pengumpulan_menunggu($id)
    {
         $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', '=', auth()->user()->id)
        ->where('pengumpulans.murid_id', '=', $id)
        ->where('pengumpulans.status', '=', 'menunggu')
        ->select([
            'murids.id',
            'pengumpulans.tugas_id',
            'murids.nama_siswa',
            'tugas.nama_tugas',
            'gurus.nama_guru',
            'tugas.deadline',
            'tugas.date',
            'pengumpulans.status'
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
        ->where('murids.id', '=', $id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->select([
            'murids.id',
            'pengumpulans.tugas_id',
            'murids.nama_siswa',
            'tugas.nama_tugas',
            'gurus.nama_guru',
            'tugas.deadline',
            'tugas.date',
            'pengumpulans.status'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List siswa selesai pengumpulan",
            "pengumpulan" => $data,
        ], 200);
    }
}
