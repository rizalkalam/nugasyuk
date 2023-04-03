<?php

namespace App\Http\Controllers\API;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuruController extends Controller
{
    public function beranda()
    {
        // $data = array();
        // $all = Guru::all();
        // foreach ($all as $guru) {
        //     if ($guru->user->niy == auth()->user()->niy) {
        //         $data[]=[
        //             'niy'=>$guru->niy,
        //             'nama_guru'=>$guru->foto_profile,
        //             'mata_pelajaran'=>$guru->mapel1->nama_mapel,
        //             // 'harga'=>$product->harga,
        //             // 'gambar_barang'=>$product->gambar_barang
        //         ];
        //     }
        // }

        // $data = array();

        // $data[]=[
        //     'niy'=>auth()->user()->niy,
        //     'nama_guru'=>auth()->user()->nama_guru,
        //     'foto_profile'=>auth()->user()->foto_profile,
        //     'mata_pelajaran'=>[
        //         'mapel1' => auth()->user()->mapel1->nama_mapel, 
        //         'mapel2' => auth()->user()->mapel2->nama_mapel ?? null
        //     ],
        // ];

        $data = array();
        $data[]=[
            'nama_guru'=>auth()->user()->nama_guru,
            'foto_profile'=>auth()->user()->foto_profile,
            'mata_pelajaran'=>[
                'mapel1'=>[
                    'judul'=>auth()->user()->mapel1->kode->nama_mapel, 
                    'kelas'=>auth()->user()->mapel1->kelas->tingkatan->tingkat_ke . ' ' . auth()->user()->mapel1->kelas->jurusan->nama_jurusan . ' ' . auth()->user()->mapel1->kelas->nama_kelas,
                    'materi'=>[
                        'judul'=>auth()->user()->mapel1->materi->judul
                    ],
                    'tugas'=>[
                        'judul'=>auth()->user()->mapel1->tugas->judul
                    ]
                ]
                // 'mapel1' => auth()->user()->mapel1->kode->nama_mapel, 
                // 'mapel2' => auth()->user()->mapel2->kode->nama_mapel ?? null
            ],
            // 'kelas_diampu'=>[
            //     auth()->user()->mapel1->kelas->tingkatan->tingkat_ke . ' ' . auth()->user()->mapel1->kelas->jurusan->nama_jurusan . ' ' . auth()->user()->mapel1->kelas->nama_kelas,
            //     auth()->user()->mapel2->kelas->tingkatan->tingkat_ke . ' ' . auth()->user()->mapel2->kelas->jurusan->nama_jurusan . ' ' . auth()->user()->mapel2->kelas->nama_kelas ?? null
            // ],
            // 'materi_diberikan'=>[
            //     auth()->user()->mapel1->materi->judul
            // ],
            // 'tugas_diberikan'=>[
            //     auth()->user()->mapel1->tugas->judul
            // ]
        ];
  
        return response()->json([
            "success" => true,
            "message" => "Beranda Guru",
            "data" => $data
        ]);
    }
}
