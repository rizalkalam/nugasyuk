<?php

namespace App\Http\Controllers\API\Guru;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailTugasPengumpulanResource;

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
        $data = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
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
                            'pengumpulans.murid_id',
                            'pengumpulans.tugas_id',
                            'murids.foto_profile',
                            'murids.nama_siswa',
                            'murids.email',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas',
                            'tugas.input_jawaban'
                        ])->first();
        
        $siswa = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('murids.id', $id)
        ->select([
            // 'pengumpulans.murid_id',
            // 'pengumpulans.tugas_id',
            'murids.id',
            'murids.foto_profile',
            'murids.nama_siswa',
            'murids.email',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
        ])->first();

        $data_siswa = [
            "murid_id" => $siswa->id,
            "tugas_id" => [],
            'nama_siswa'=>$siswa->nama_siswa,
            'email'=>$siswa->email,
            'tingkat_ke'=>$siswa->tingkat_ke,
            'nama_jurusan'=>$siswa->nama_jurusan,
            'nama_kelas'=>$siswa->nama_kelas,
        ];

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ada',
                'pengumpulan' => $data_siswa
            ], 200);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Detail Siswa",
                "pengumpulan" => $data,
            ], 200);
        }
    }

    public function detail_tugas_pengumpuluan($id)
    {
        $tugas = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
                        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
                        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
                        ->join('kodes','kodes.id', '=', 'mapels.kode_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->where('pengumpulans.id', '=', $id)
                        ->select([
                            'pengumpulans.id',
                            'pengumpulans.murid_id',
                            'pengumpulans.tugas_id',
                            'pengumpulans.status',
                            'murids.foto_profile',
                            'murids.nama_siswa',
                            'murids.email',
                            'tingkatans.tingkat_ke',
                            'jurusans.nama_jurusan',
                            'kelas.nama_kelas',
                            'gurus.nama_guru',
                            'tugas.nama_tugas',
                            'tugas.soal',
                            'tugas.date',
                            'tugas.deadline',
                            'tugas.link_tugas',
                            'tugas.file_tugas',
                            'tugas.input_jawaban',
                            // 'pengumpulans.link',
                            'pengumpulans.file'
                        ])->get();

        $data = DetailTugasPengumpulanResource::collection($tugas);

            return response()->json([
                "success" => true,
                "message" => "Detail Tugas",
                "tugas" => $data,
            ], 200);
        
    }

    public function konfirmasi($id)
    {
        $pengumpulan = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', '=', auth()->user()->id)
        ->where('pengumpulans.id', '=', $id)
        ->where('pengumpulans.status', '=', 'menunggu_dalam_deadline')
        ->orWhere('pengumpulans.status', '=', 'menunggu_lebih_deadline')
        ->first();

        $deadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.id', $id)
        ->value('tugas.deadline');

        if (!empty($pengumpulan)) {

            if (Carbon::now() <= $deadline) {
                $status = Pengumpulan::join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
                ->where('pengumpulans.id', $id)
                ->update(['status'=>'selesai_dalam_deadline']);
    
                return response()->json([
                    "success" => true,
                    "message" => "Pengumpulan berhasil dikonfirmasi",
                    "pengumpulan" => Pengumpulan::where('id', $id)->first(),
                    'tes'=>$deadline
                ], 200);
            }

            $status = Pengumpulan::join('murids', 'murids.id', '=', 'pengumpulans.murid_id')
            ->where('pengumpulans.id', $id)
            ->update(['status'=>'selesai_lebih_deadline']);

            return response()->json([
                "success" => true,
                "message" => "Pengumpulan berhasil dikonfirmasi",
                "pengumpulan" => Pengumpulan::where('id', $id)->first(),
            ], 200);

           
        }
        return response()->json([
            "success" => true,
            "message" => "Tidak ada data",
            "pengumpulan" => $pengumpulan,
        ], 400);
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
        ->where('murids.id', '=', $id)
        ->where( function ($query){
            return $query
                    ->where('pengumpulans.status', '=','menunggu_dalam_deadline')
                    ->orWhere('pengumpulans.status', '=','menunggu_lebih_deadline');
        })
        ->select([
            'pengumpulans.id',
            'pengumpulans.murid_id',
            'pengumpulans.tugas_id',
            'murids.foto_profile',
            'murids.nama_siswa',
            'murids.email',
            'tugas.nama_tugas',
            'gurus.nama_guru',
            'tugas.deadline',
            'tugas.date',
            'tugas.input_jawaban',
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
        ->where(function ($query) {
            $query->where('pengumpulans.status', '=', 'selesai_dalam_deadline')
            ->orWhere('pengumpulans.status', '=', 'selesai_lebih_deadline');
        })
        ->select([
            'pengumpulans.id',
            'pengumpulans.murid_id',
            'pengumpulans.tugas_id',
            'murids.foto_profile',
            'murids.nama_siswa',
            'murids.email',
            'tugas.nama_tugas',
            'gurus.nama_guru',
            'tugas.deadline',
            'tugas.date',
            'tugas.input_jawaban',
            'pengumpulans.status'
        ])->get();

        return response()->json([
            "success" => true,
            "message" => "List siswa selesai pengumpulan",
            "pengumpulan" => $data,
        ], 200);
    }

    public function data_kelas()
    {
        $data = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
                        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
                        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
                        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
                        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
                        ->where('gurus.id', '=', auth()->user()->id)
                        ->select(['kelas.id', 'tingkatans.tingkat_ke', 'jurusans.nama_jurusan', 'kelas.nama_kelas'])
                        ->distinct()
                        ->get();

        return response()->json([
            "success" => true,
            "message" => "KBM",
            "kelas" => $data,
        ], 200);
    }
}
