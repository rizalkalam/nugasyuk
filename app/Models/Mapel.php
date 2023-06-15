<?php

namespace App\Models;

use App\Models\Kode;
use App\Models\Asset;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function scopeFilter($query, array $kelas)
    // {
    //     $query->when($filters['kelas']??false, function($query, $kelas){
    //         return $query->whereHas('kelas', function($query) use ($kelas){
    //             $query->where('id', $kelas);
    //         });
    //     });
    // }    

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

}
