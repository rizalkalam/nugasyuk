<?php

namespace App\Http\Controllers\API\Ortu;

use App\Models\Ortu;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class OrtuBerandaController extends Controller
{
    public function data_ortu()
    {
        $ortu = Ortu::where('id', auth()->user()->id)->value('nama');

        $siswa_id = Ortu::where('id', auth()->user()->id)->value('siswa_id');

        $kelas_siswa = Murid::where('id', auth()->user()->siswa_id)->value('kelas_id');

        $jumlah_murid = Murid::where('kelas_id', $kelas_siswa)->select('id')->get()->count();

        $jumlah_mapel = Mapel::where('kelas_id', $kelas_siswa)
        ->select('id')->get()->count();

        $wali_kelas = Kelas::join('gurus', 'gurus.id', '=', 'kelas.guru_id')
        ->where('kelas.id', $kelas_siswa)
        ->value('gurus.nama_guru');

        $deadline = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->where('mapels.kelas_id', $kelas_siswa)
        ->value('tugas.deadline');

        $belum_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', $siswa_id)
        ->where('pengumpulans.status', '=', 'belum_selesai')
        ->whereDate('pengumpulans.tanggal', '<=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $selesai_dalamdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', $siswa_id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->whereDate('pengumpulans.tanggal', '<=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $belum_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', $siswa_id)
        ->where('pengumpulans.status', '=', 'belum_selesai')
        ->whereDate('pengumpulans.tanggal', '>=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $selesai_lebihdeadline = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->where('pengumpulans.murid_id', $siswa_id)
        ->where('pengumpulans.status', '=', 'selesai')
        ->whereDate('pengumpulans.tanggal', '>=', $deadline)
        ->select('pengumpulans.id')->get()->count();

        $data = [
            "nama" => $ortu,
            "jumlah_siswa" => $jumlah_murid,
            "jumlah_mapel" => $jumlah_mapel,
            "wali_kelas" => $wali_kelas,
            "belum_dalamdeadline" => $belum_dalamdeadline,
            "selesai_dalamdeadline" => $selesai_dalamdeadline,
            "belum_lebihdeadline" => $belum_lebihdeadline,
            "selesai_lebihdeadline" => $selesai_lebihdeadline,
        ];

        return response()->json([
            "data" => $data
        ]);  
    }
}
