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

    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search']??false, function($query, $search){
    //         return $query->where('nama_siswa', 'like', '%' . $search . '%')
    //         ->orWhere('nama_siswa', 'like', '%' . $search . '%');
    //     });

    //     // $query->when($filters['kelas']??false, function($query, $category){
    //     //     return $query->whereHas('kelas', function($query) use ($category){
    //     //         $query->where('id', $category);
    //     //     });
    //     // });
    // }
}
