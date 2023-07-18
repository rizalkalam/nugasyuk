<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminListMapelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $nama_mapel = $this->nama_mapel;
        $nama_guru = $this->nama_guru;

        return [
            'id'=>$this->id,
            'kelas_id'=>$this->kelas_id,
            'nama_mapel'=>$nama_mapel !== null ? $nama_mapel : 0,
            'nama_guru'=>$nama_guru !== null ? $nama_guru : 0,
            'tingkat_ke'=>$this->tingkat_ke,
            'nama_jurusan'=>$this->nama_jurusan,
            'nama_kelas'=>$this->nama_kelas,
            'file_asset'=>$this->file_asset
        ];

    }
}
