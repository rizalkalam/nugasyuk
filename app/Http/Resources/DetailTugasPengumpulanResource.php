<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailTugasPengumpulanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $file = $this->file;
        $link_tugas = $this->link_tugas;
        $file_tugas = $this->file_tugas;
        // $nama_mapel = $this->nama_mapel;

        return[
            "pengumpulan_id" => $this->id,
            "murid_id" => $this->murid_id,
            "tugas_id" => $this->tugas_id,
            "foto_profile" => $this->foto_profile,
            "nama_siswa" => $this->nama_siswa,
            "email" => $this->email,
            "tingkat_ke" => $this->tingkat_ke,
            "nama_jurusan" => $this->nama_jurusan,
            "nama_kelas" => $this->nama_kelas,
            "nama_guru" => $this->nama_guru,
            "nama_tugas" => $this->nama_tugas,
            "soal" => $this->soal,
            "date" => $this->date,
            "deadline" => $this->deadline,
            "status" => $this->status,
            "soal_link" => $this->link_tugas,
            "soal_file" => $this->file_tugas,
            "file" => $this->file,
            "input_jawaban" => $this->input_jawaban
            // "nama_file_soal"=>$this->file_tugas->getClientOriginalName(),
            // "nama_file_tugas"=>$this->file->getClientOriginalName()
            // "file" => !empty($file) ? $file : [],
            // "nama_mapel" => !empty($nama_mapel) ? $nama_mapel : [],
        ];
    }
}
