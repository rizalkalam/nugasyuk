<?php

namespace App\Http\Controllers\API\Murid;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class MuridBerandaController extends Controller
{
    public function data_murid()
    {
        $murid = Murid::where('id', auth()->user()->id)->value('nama_panggilan');

        $jumlah_murid = Murid::where('kelas_id', auth()->user()->kelas_id)
        ->select('id')->get()->count();

        $jumlah_mapel = Mapel::where('kelas_id', auth()->user()->kelas_id)
        ->select('id')->get()->count();

        $wali_kelas = Kelas::join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', auth()->user()->kelas_id)
        ->value('gurus.nama_guru');

        $tugas = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->select('tugas.id')->get()->count();

        $belum_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'belum_selesai_dalam_deadline')
        ->select('pengumpulans.id')->get()->count();

        $selesai_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'selesai_dalam_deadline')
        ->select('pengumpulans.id')->get()->count();

        $belum_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'belum_selesai_luar_deadline')
        ->select('pengumpulans.id')->get()->count();

        $selesai_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'selesai_lebih_deadline')
        ->select('pengumpulans.id')->get()->count();

        $menunggu_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'menunggu_dalam_deadline')
        ->select('pengumpulans.id')->get()->count();

        $menunggu_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'menunggu_lebih_deadline')
        ->select('pengumpulans.id')->get()->count();

        $data = [
            "nama" => $murid,
            "jumlah_siswa" => $jumlah_murid,
            "jumlah_mapel" => $jumlah_mapel,
            "wali_kelas" => $wali_kelas,
            "belum_dalamdeadline" => $belum_dalamdeadline,
            "selesai_dalamdeadline" => $selesai_dalamdeadline,
            "belum_lebihdeadline" => $belum_lebihdeadline,
            "selesai_lebihdeadline" => $selesai_lebihdeadline,
            "menunggu_dalamdeadline" => $menunggu_dalamdeadline,
            "menunggu_lebihdeadline" => $menunggu_lebihdeadline,
            "jumlah_tugas" => $tugas,
            // "deadline"=>$deadline
        ];

        return response()->json([
           "data" => $data
        ]);
    }
}
