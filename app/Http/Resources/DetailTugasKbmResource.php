<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailTugasKbmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        // $link_tugas = $this->link_tugas;
        // $file_tugas = $this->file_tugas;

        return[
            "id" => $this->id,
            "kelas_id" => $this->kelas_id,
            "nama_guru" => $this->nama_guru,
            "nama_tugas" => $this->nama_tugas,
            "soal" => $this->soal,
            "date" => $this->date,
            "deadline" => $this->deadline,
            "soal_link" => $this->link_tugas,
            "soal_file" => $this->file_tugas,
            "input_jawaban" => $this->input_jawaban
        ];
    }
}
