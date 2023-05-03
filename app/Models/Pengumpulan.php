<?php

namespace App\Models;

use App\Models\Murid;
use App\Models\Tugas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }
}
