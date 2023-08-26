<?php

namespace App\Http\Resources;

use App\Models\Tugas;
use App\Models\Pengumpulan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruPengumpulanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $data_tugas = Tugas::join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->where('mapels.kelas_id', $this->kelas_id)
        ->get()
        ->count();


        $tugas_menunggu = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->where('pengumpulans.murid_id', $this->id)
        ->where( function ($query){
            return $query
            ->orWhere('pengumpulans.status', 'menunggu_dalam_deadline')
            ->orWhere('pengumpulans.status', 'menunggu_lebih_deadline');
        })
        ->get()
        ->count();

        $tugas_selesai = Pengumpulan::join('tugas', 'tugas.id', '=', 'pengumpulans.tugas_id')
        ->join('mapels', 'mapels.id', '=', 'tugas.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->where('kodes.guru_id', auth()->user()->id)
        ->where('pengumpulans.murid_id', $this->id)
        ->where( function ($query){
            return $query
            ->where('pengumpulans.status', '=','selesai_dalam_deadline')
            ->orWhere('pengumpulans.status', '=','selesai_lebih_deadline');
        })
        ->get()
        ->count();


        return [
            'id' => $this->id,
            'kelas_id' => $this->kelas_id,
            'foto_profile' => $this->foto_profile,
            'nama_siswa' => $this->nama_siswa,
            'email' => $this->email,
            'tingkat_ke' => $this->tingkat_ke,
            'nama_jurusan' => $this->nama_jurusan,
            'nama_kelas' => $this->nama_kelas,
            'tugas_menunggu' => $tugas_menunggu,
            'tugas_selesai' => $tugas_selesai,
            'jumlah_tugas' => $data_tugas
        ];
    }
}
