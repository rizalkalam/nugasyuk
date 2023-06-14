<?php

namespace App\Http\Resources;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $foto = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->where('mapels.kelas_id', auth()->user()->kelas_id)
        ->where('haris.id', $this->id)
        ->select(['gurus.foto_profile'])->get();

        return [
            'id'=>$this->id,
            'hari' => $this->hari,
            'detail' => $foto
            // 'links' => [
            //     'self' => 'link-value',
            // ],
        ];

    }
}
