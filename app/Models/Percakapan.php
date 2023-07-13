<?php

namespace App\Models;

use App\Models\Pesan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percakapan extends Model
{
    use HasFactory;

    public function pesans()
    {
         return $this->hasMany(Pesan::class);
    }
}
