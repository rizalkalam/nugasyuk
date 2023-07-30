<?php

namespace App\Models;

use App\Models\Jam;
use App\Models\Guru;
use App\Models\Murid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Janjian extends Model
{
    use HasFactory;

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function jam()
    {
        return $this->belongsTo(Jam::class);
    }
}
