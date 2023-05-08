<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Guru;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBerandaController extends Controller
{
    public function data_admin()
    {
        $admin = Admin::where('id', auth()->user()->id)->value('nama');

        $murid = Murid::all();
        $jumlah_murid = count($murid);

        $kelas = Kelas::all();
        $jumlah_kelas = count($kelas);

        $guru = Guru::all();
        $jumlah_guru = count($guru);

        $jurusan = Jurusan::all();
        $jumlah_jurusan = count($jurusan);

        return response()->json([
            "success" => true,
            "message" => "Jumlah Kelas Diampu",
            // "data_guru" => $data
            "nama" => $admin,
            "jumlah_siswa" => $jumlah_murid,
            "jumlah_kelas" => $jumlah_kelas,
            "jumlah_guru" => $jumlah_guru,
            "jumlah_jurusan" => $jumlah_jurusan
        ]);
    }
}
