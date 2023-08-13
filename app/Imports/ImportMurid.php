<?php

namespace App\Imports;

use App\Models\Ortu;
use App\Models\Murid;
use App\Imports\OrtuSheetImport;
use App\Imports\MuridSheetImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class ImportMurid implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // use WithConditionalSheets;

    // public function conditionalSheets(): array
    // {
    //     return [
    //         'Murid' => new MuridSheetImport(),
    //         'Wali_Murid' => new OrtuSheetImport(),
    //     ];
    // }

    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
                '*.nis' => 'required|unique:murids',
                '*.nama_panggilan' => 'required',
                '*.nama_siswa' => 'required',
                '*.email' => 'required|email|unique:murids|unique:gurus|unique:admins',
                '*.password' => 'required',
                '*.alamat' => 'required',
    
                // validasi input wali murid
                '*.nama_wali'=>'required',
                '*.email_wali'=>'required|email|unique:ortus,email',
                '*.password'=>'required',
            ])->validate();

        foreach ($rows as $row)
        {
            Murid::create([
            'nis'=>$row['nis'],
            'nama_panggilan'=>$row['nama_panggilan'],
            'nama_siswa'=>$row['nama_siswa'],
            'email'=>$row['email'],
            'password'=>bcrypt($row['password']),
            'foto_profile'=>$row['foto_profile'],
            'alamat'=>$row['alamat'],
            'kelas_id'=>$row['kelas_id']
           ]);

           Ortu::create([
            'nama'=>$row['nama_wali'],
            'email'=>$row['email_wali'],
            'password'=>$row['password_wali'],
            'siswa_id'=>$row['id']
           ]);
        }
    }
}
