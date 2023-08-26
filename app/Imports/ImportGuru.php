<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGuru implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.nama_guru' => 'required',
            '*.email' => 'required|email|unique:admins|unique:murids|unique:gurus,email',
            '*.niy' => 'required|unique:gurus',
            '*.nomor_tlp' => 'required',
            '*.alamat' => 'required'
        ])->validate();

        foreach ($rows as $row) {
            if (empty(explode(' ',trim($row['nama_guru']))[1])) {
                $kostumisasi_password = Carbon::now()->format('Y').'_'.explode(' ',trim($row['nama_guru']))[0].'_'.$row['niy'];
            } else {
                $kostumisasi_password = Carbon::now()->format('Y').'_'.explode(' ',trim($row['nama_guru']))[0].'_'.explode(' ',trim($row['nama_guru']))[1].'_'.$row['niy'];
            }
            Guru::create([
            'nama_guru'=>$row['nama_guru'],
            'email'=>$row['email'],
            'password'=>Hash::make($kostumisasi_password),
            'niy'=>$row['niy'],
            'alamat'=>$row['alamat'],
            'nomor_tlp'=>$row['nomor_tlp'],
            'foto_profile'=>$row['foto_profile'],
            'kode_id'=>$row['kode_id'],
            ]);
        }
    }
    
    // public function model(array $row)
    // {
    //     Validator::make($row, [
    //         'nama_guru' => 'required',
    //         'email' => 'required|email|unique:admins|unique:murids|unique:gurus,email',
    //         'niy' => 'required|unique:gurus',
    //         'nomor_tlp' => 'required',
    //         'alamat' => 'required'
    //         // 'password' => 'required',
    //         // 'foto_profile' => 'required|file|max:2048|mimes:jpeg,png,jpg',
    //     ])->validate();

        
    //     return new Guru([
    //         $kostumisasi_password = 'eofnwio',

    //         'nama_guru'=>$row['nama_guru'],
    //         'email'=>$row['email'],
    //         'password'=>$kostumisasi_password,
    //         'niy'=>$row['niy'],
    //         'alamat'=>$row['alamat'],
    //         'nomor_tlp'=>$row['nomor_tlp'],
    //         'foto_profile'=>$row['foto_profile'],
    //         'kode_id'=>$row['kode_id'],
    //     ]);
    // }
}
