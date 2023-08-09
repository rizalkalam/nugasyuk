<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruListMateriResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            "id" => $this->id,
            "kelas_id" => $this->kelas_id,
            "nama_materi" => $this->nama_materi,
            "nama_guru" => $this->nama_guru,
            "tanggal_dibuat" => Carbon::parse($this->tanggal_dibuat)->format('d-m-Y')
        ];
    }
}
