<?php

namespace App\Http\Resources;

use App\Models\Kode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminListGuruResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $kode = Kode::join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->where('gurus.id', $this->id)
        ->select(['kodes.id', 'kodes.kode_guru'])->get();

        return [
            'id'=>$this->id,
            'niy'=>$this->niy,
            'foto_profile'=>$this->foto_profile,
            'nama_guru'=>$this->nama_guru,
            'email'=>$this->email,
            'status_mapel'=>$this->status_mapel,
            'kode_guru'=>$kode
        ];
    }
}
