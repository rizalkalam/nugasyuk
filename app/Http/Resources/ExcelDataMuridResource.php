<?php

namespace App\Http\Resources;

use App\Models\Ortu;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class ExcelDataMuridResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $ortu = Ortu::where('siswa_id', $this->id)
        ->select([
            'nama',
            'email',
            // 'password'
        ])
        ->first();

        $nama_kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->where('kelas.id', $this->kelas_id)
        ->select(   
               DB::raw("CONCAT(tingkatans.tingkat_ke, ' ', jurusans.nama_jurusan, ' ', kelas.nama_kelas) AS kelas_lengkap")
            )
        ->value('kelas_lengkap');

        return [
            'id'=>$this->id,
            'nis'=>$this->nis,
            'nama_panggilan'=>$this->nama_panggilan,
            'nama_siswa'=>$this->nama_siswa,
            'email'=>$this->email,
            'alamat'=>$this->alamat,
            'nama_wali'=>$ortu->nama,
            'email_wali'=>$ortu->email,
            // 'password_wali'=>$ortu->password,
            'foto_profile'=>$this->foto_profile,
            'kelas'=>$nama_kelas
        ];
    }
}
