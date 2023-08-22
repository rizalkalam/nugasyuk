<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExcelDataGuruResource extends JsonResource
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
            'id'=>$this->id,
            'nama_guru'=>$this->nama_guru,
            'email'=>$this->email,
            // 'password'=>$this->password,
            'niy'=>$this->niy,
            'alamat'=>$this->alamat,
            'nomor_tlp'=>$this->nomor_tlp,
            'foto_profile'=>$this->foto_profile,
            'kode_id'=>$this->kode_id
        ];
    }
}
