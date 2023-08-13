<?php

namespace App\Imports;

use App\Models\Ortu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\HasReferencesToOtherSheets;

class OrtuSheetImport implements ToModel, HasReferencesToOtherSheets
{
    public function model(array $row)
    {
        Validator::make($row, [
            //validasi input wali murid
            'nama'=>'required',
            'email_wali'=>'required|email|unique:ortus,email',
            'password'=>'required',
        ])->validate();

        return new Ortu([
            'nama'=>$row['nama_wali'],
            'email_wali'=>$row['email_wali'],
            'password'=>$row['password_wali'],
            'siswa_id'=>$row['#']
        ]);
    }
}
