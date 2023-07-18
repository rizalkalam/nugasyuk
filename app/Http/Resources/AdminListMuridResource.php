<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminListMuridResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $nama_jurusan = $this->nama_jurusan;

        return [
            'id'=>$this->id,
            'nis'=>$this->nis,
            'foto_profile'=>$this->foto_profile,
            'nama_siswa'=>$this->nama_siswa,
            'email'=>$this->email,
            'nama_jurusan'=>$nama_jurusan !== null ? $nama_jurusan : 0,
        ];
    }
}
