<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Guru;
use App\Models\Kode;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminGuruController extends Controller
{
    public function index()
    {
        $nama_guru = request('nama_guru', null);
        $status_mapel = request('status_mapel', null);
        $data = Guru::join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        ->when($status_mapel, function ($query) use ($status_mapel){
            $query->where('mapels.status_mapel', $status_mapel);
        })
        ->when($nama_guru, function ($query) use ($nama_guru){
            $query->where('gurus.nama_guru', 'LIKE', '%' . $nama_guru . '%');
        })
        ->select(['gurus.id', 'gurus.nama_guru', 'gurus.email', 'mapels.status_mapel'])->get();

        $jumlah_guru = count(Guru::all());

        return response()->json([
            "success" => true,
            "message" => "List Guru",
            "jumlah_guru" => $jumlah_guru,
            "data" => $data,
        ], 200);
    }

    public function detail($id)
    {
        $mapel = Mapel::join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('kodes.guru_id', $id)
        ->select([
            'kodes.nama_mapel',
            'tingkatans.tingkat_ke',
            'jurusans.nama_jurusan',
            'kelas.nama_kelas',
        ])->get();

        $guru = Guru::join('mapels', 'mapels.id', '=', 'gurus.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('gurus.id', $id)
        ->select([
            'gurus.id',
            'gurus.foto_profile',
            'gurus.nama_guru',
            'gurus.email',
            // 'kodes.nama_mapel',
            // 'kodes.kode_guru',
            // 'tingkatans.tingkat_ke',
            // 'jurusans.nama_jurusan',
            // 'kelas.nama_kelas',
        ])
        ->first();

        $data = [
            'id'=>$guru->id,
            'foto_profile'=>$guru->foto_profile,
            'nama_guru'=>$guru->nama_guru,
            'email'=>$guru->email,
            'detail'=>$mapel
            // 'profile' => $guru,
            // 'detail' => $mapel
        ];

        return response()->json([
            "success" => true,
            "message" => "Detail Guru",
            "data" => $data
        ], 200);
    }
}
