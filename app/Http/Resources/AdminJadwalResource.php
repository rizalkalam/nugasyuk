<?php

namespace App\Http\Resources;

use App\Models\Kelas;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminJadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $kelas = request ('kelas', null);

        $foto = Jadwal::join('mapels', 'mapels.id', '=', 'jadwals.mapel_id')
        ->join('kodes', 'kodes.id', '=', 'mapels.kode_id')
        ->join('gurus', 'gurus.id', '=', 'kodes.guru_id')
        ->join('haris', 'haris.id', '=', 'jadwals.hari_id')
        ->when($kelas, function ($query) use ($kelas){
            return $query->whereHas('mapel', function ($query) use ($kelas){
                $query->where('kelas_id', $kelas);
            });
        })
        ->where('haris.id', $this->id)
        ->groupBy('gurus.id')
        ->select([
            'gurus.id',
            'gurus.foto_profile',
        ])
        ->get();

        return [
            'id'=>$this->id,
            'hari' => $this->hari,
            'detail' => $foto
        ];
    }
}
