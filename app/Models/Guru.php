<?php

namespace App\Models;

use App\Models\Kode;
use App\Models\Mapel;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Guru extends Authenticatable implements JWTSubject
{
    use HasFactory, HasRoles;

    public function guardName()
    {
      return 'guru';
    }

    protected $guarded = ['id'];

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

    // relation 
    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }

    // public function mapel2()
    // {
    //     return $this->belongsTo(Mapel::class);
    // }
}
