<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Materi;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Murid extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $primaryKey = 'nis';

    // public $incrementing = false;
    // protected $keyType = 'string';

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function($model){
    //         if ($model->getKey() == null) {
    //              $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
    //         }
    //     });
    // }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // public function getIncrementing()
    // {
    //     return false;
    // }

    // public function getKeyType()
    // {
    //     return 'string';
    // }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search']??false, function($query, $search){
            return $query->where('nama_siswa', 'like', '%' . $search . '%')
            ->orWhere('nama_siswa', 'like', '%' . $search . '%');
        });

        // $query->when($filters['kelas']??false, function($query, $category){
        //     return $query->whereHas('kelas', function($query) use ($category){
        //         $query->where('id', $category);
        //     });
        // });
    }
}
