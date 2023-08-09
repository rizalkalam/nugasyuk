<?php

namespace App\Models;

use App\Models\Mapel;
use App\Models\Murid;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $date = 'dd/mm/yyyy';

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
