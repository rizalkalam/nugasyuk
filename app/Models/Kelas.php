<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
