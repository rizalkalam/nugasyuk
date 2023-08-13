<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportGuru implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    
    public function model(array $row)
    {
        Validator::make($row, [
            'nama_guru' => 'required',
            'email' => 'required|email|unique:admins|unique:murids|unique:gurus,email',
            'password' => 'required',
            'niy' => 'required|unique:gurus',
            // 'foto_profile' => 'required|file|max:2048|mimes:jpeg,png,jpg',
            'nomor_tlp' => 'required',
            'alamat' => 'required'
        ])->validate();

        return new Guru([
            'nama_guru'=>$row['nama_guru'],
            'email'=>$row['email'],
            'password'=>bcrypt($row['password']),
            'niy'=>$row['niy'],
            'alamat'=>$row['alamat'],
            'nomor_tlp'=>$row['nomor_tlp'],
            'foto_profile'=>$row['foto_profile'],
            'kode_id'=>$row['kode_id'],
        ]);

    //     Validator::make($rows->toArray(), [
    //         'nama_guru' => 'required',
    //         'email' => 'required|email|unique:gurus',
    //         'password' => 'required',
    //         'niy' => 'required|unique:gurus',
    //         // 'foto_profile' => 'required|file|max:2048|mimes:jpeg,png,jpg',
    //         'nomor_tlp' => 'required',
    //         'alamat' => 'required'
    //     ])->validate();

    //    foreach ($rows as $row) {
    //        Guru::create([
    //         'nama_guru'=>$row[0],
    //         'email'=>$row[1],
    //         'password'=>bcrypt($row[3]),
    //         'niy'=>$row[4],
    //         'alamat'=>$row[5],
    //         'nomor_tlp'=>$row[6],
    //         'foto_profile'=>$row[7],
    //         'kode_id'=>$row[8],
    //        ]);
    //    }
    }
}
