<?php

namespace App\Models;

use App\Models\Mapel;
use App\Models\Tugas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function tugas()
    {
        return $this->HasMany(Tugas::class);
    }
}
