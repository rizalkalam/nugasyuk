<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruDetailTugasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $link = $this->link;
        $file = $this->file;

        return[
            "id" => $this->id,
            "nama_guru" => $this->nama_guru,
            "nama_tugas" => $this->nama_tugas,
            "soal" => $this->soal,
            "date" => $this->date,
            "link" => !empty($link) ? $link : [],
            "file" => !empty($file) ? $file : [],
        ];
    }
}
