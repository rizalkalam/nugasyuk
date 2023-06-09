<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminMuridController extends Controller
{
    public function index()
    {
        $jurusan = request('jurusan', null);
        $jurusan_id = Kelas::join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->when($jurusan, function ($query) use ($jurusan){
                return $query->whereHas('jurusan', function ($query) use ($jurusan) {
                    $query->where('id', $jurusan);
                });
            })->select(['jurusans.id'])->first();

        $data = Murid::join('kelas', 'kelas.id', '=', 'murids.kelas_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('jurusans.id', $jurusan_id->id)
        ->select(['murids.id', 'murids.nama_siswa', 'murids.email', 'jurusans.nama_jurusan'])->get();

        $jumlah_murid = count(Murid::all());

        return response()->json([
            "success" => true,
            "message" => "List Siswa",
            "data" => $data,
            "jumlah_siswa" => $jumlah_murid
        ], 200);
    }

    public function buat_murid(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_siswa'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'foto_profile'=> 'required',
            'kelas_id'=> 'required'
        ]);

        $data = Murid::create([
            'nama_siswa' => $request->nama_siswa,
            'email' => $request->email,
            'password' => $request->password,
            'foto_profile' => $request->foto_profile,
            'kelas_id' => $request->kelas_id
        ]);

        return response()->json([
            'message' => 'Data Siswa baru berhasil dibuat',
            'data' => $data,
        ]);
    }
}
