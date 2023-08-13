<?php

namespace App\Imports;

use App\Models\Ortu;
use App\Models\Murid;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class MuridSheetImport implements ToArray, HasReferencesToOtherSheets
{

    public function model(array $row)
    {
        Validator::make($row, [
            'nis' => 'required|unique:murids',
            'nama_panggilan' => 'required',
            'nama_siswa' => 'required',
            'email' => 'required|email|unique:murids|unique:gurus|unique:admins',
            'password' => 'required',
            'alamat' => 'required',

            //validasi input wali murid
            // 'nama'=>'required',
            // 'email_wali'=>'required|email|unique:ortus,email',
            // 'password'=>'required',
        ])->validate();

        // $ortu = Ortu::create([
        //     'nama'=>$row['nama_wali'],
        //     'email_wali'=>$row['email_wali'],
        //     'password'=>$row['password_wali'],
        //     'siswa_id'=>$row['#']
        // ]);

        return new Murid([
            'nis'=>$row['nis'],
            'nama_panggilan'=>$row['nama_panggilan'],
            'nama_siswa'=>$row['nama_siswa'],
            'email'=>$row['email'],
            'password'=>bcrypt($row['password']),
            'foto_profile'=>$row['foto_profile'],
            'alamat'=>$row['alamat'],
            'kelas_id'=>$row['kelas_id']
        ]);
    }
}
