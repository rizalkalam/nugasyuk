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
        $murid = Murid::where('id', auth()->user()->id)->value('nama_siswa');

        $jumlah_murid = Murid::where('kelas_id', auth()->user()->kelas_id)
        ->select('id')->get()->count();

        $jumlah_mapel = Mapel::where('kelas_id', auth()->user()->kelas_id)
        ->select('id')->get()->count();

        $wali_kelas = Kelas::join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', auth()->user()->kelas_id)
        ->value('gurus.nama_guru');

        $tugas = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->select('tugas.id')->get()->count();

        $deadline = Tugas::join('materis', 'materis.id', '=', 'tugas.materi_id')
        ->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->value('tugas.deadline');

        $belum_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'belum_selesai')
        ->whereDate('pengumpulans.tanggal', '<=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $selesai_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->whereDate('pengumpulans.tanggal', '<=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $belum_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'belum_selesai')
        ->whereDate('pengumpulans.tanggal', '>=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $selesai_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', auth()->user()->id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->whereDate('pengumpulans.tanggal', '>=', $deadline)
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
            "jumlah_tugas" => $tugas
        ];

        return response()->json([
           "data" => $data
        ]);
    }
}
