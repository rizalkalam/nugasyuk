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

        // $file = $this->file;
        // $link_tugas = $this->link_tugas;
        // $file_tugas = $this->file_tugas;
        // $nama_mapel = $this->nama_mapel;

        return[
            "pengumpulan_id" => $this->id,
            "murid_id" => $this->murid_id,
            "tugas_id" => $this->tugas_id,
            "nama_guru" => $this->nama_guru,
            "nama_tugas" => $this->nama_tugas,
            "soal" => $this->soal,
            "date" => $this->date,
            "deadline" => $this->deadline,
            "status" => $this->status,
            "soal_link" => $this->link_tugas,
            "soal_file" => $this->file_tugas,
            "file" => $this->file,
            // "nama_file_soal"=>$this->file_tugas->getClientOriginalName(),
            // "nama_file_tugas"=>$this->file->getClientOriginalName()
            // "file" => !empty($file) ? $file : [],
            // "nama_mapel" => !empty($nama_mapel) ? $nama_mapel : [],
        ];
    }
}
