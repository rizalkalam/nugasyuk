<?php

namespace App\Models;

use App\Models\Murid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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

    
}
