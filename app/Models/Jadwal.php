<?php

namespace App\Models;

use App\Models\Jam;
use App\Models\Hari;
use App\Models\Kode;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jam()
    {
        return $this->belongsTo(Jam::class);
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class);
    }

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
