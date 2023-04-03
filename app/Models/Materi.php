<?php

namespace App\Models;

use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
        return $this->hasMany(Mapel::class);
    }

    public function materi()
    {
        return $this->HasMany(Materi::class);
    }
}
