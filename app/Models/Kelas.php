<?php

namespace App\Models;

use App\Models\Guru;
use App\Models\Murid;
use App\Models\Jurusan;
use App\Models\Tingkatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, array $kelas)
    {
        $query->when($filters['id']??false, function($query, $kelas){
            return $query->whereHas('id', function($query) use ($kelas){
                $query->where('id', $kelas);
            });
        });
    }    

    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function murids()
    {
        return $this->hasMany(Murid::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    
}
