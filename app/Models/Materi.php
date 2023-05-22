<?php

namespace App\Models;

use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $kelas)
    {
        $query->join('mapels', 'mapels.id', '=', 'materis.mapel_id')
        ->join('kelas', 'kelas.id', '=', 'mapels.kelas_id')
        ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
        ->join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
        ->where('gurus.id', '=', auth()->user()->id)
        ->when($filters['kelas.id']??false, function($query, $kelas){
            return $query->whereHas('kelas.id', function($query) use ($kelas){
                $query->where('kelas.id', $kelas);
            });
        });
    }    

public function mapel()
    {
        return $this->belongsTo(Mapel::class);
        // return $this->hasMany(Mapel::class);
    }

    public function materi()
    {
        return $this->HasMany(Materi::class);
    }
}
