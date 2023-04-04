<?php

namespace App\Models;

use App\Models\Kode;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

}
