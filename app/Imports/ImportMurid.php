<?php

namespace App\Imports;

use App\Models\Ortu;
use App\Models\Kelas;
use App\Models\Murid;
use App\Imports\OrtuSheetImport;
use App\Imports\MuridSheetImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
                '*.nis' => 'required|unique:murids',
                '*.nama_panggilan' => 'required',
                '*.nama_siswa' => 'required',
                '*.email' => 'required|email|unique:murids|unique:gurus|unique:admins',
                '*.password' => 'required',
                '*.alamat' => 'required',
                '*.kelas' => 'required',

                // validasi input wali murid
                '*.nama_wali'=>'required',
                '*.email_wali'=>'required|email|unique:ortus,email',
                '*.password'=>'required',
            ])->validate();

        

        foreach ($rows as $row)
        {
            $input_kelas = $row['kelas'];
            $kelas = Kelas::join('tingkatans', 'tingkatans.id', '=', 'kelas.tingkatan_id')
            ->join('jurusans', 'jurusans.id', '=', 'kelas.jurusan_id')
            ->where(
                DB::raw("CONCAT(tingkatans.tingkat_ke, ' ', jurusans.nama_jurusan, ' ', kelas.nama_kelas)"), $input_kelas
                )
            ->get('kelas.id');

            if (!empty($kelas)) {
                foreach ($kelas as $key) {
                    Murid::create([
                        'nis'=>$row['nis'],
                        'nama_panggilan'=>$row['nama_panggilan'],
                        'nama_siswa'=>$row['nama_siswa'],
                        'email'=>$row['email'],
                        'password'=>bcrypt($row['password']),
                        'foto_profile'=>$row['foto_profile'],
                        'alamat'=>$row['alamat'],
                        'kelas_id'=>$key->id
                    ]);
                }
                Ortu::create([
                 'nama'=>$row['nama_wali'],
                 'email'=>$row['email_wali'],
                 'password'=>$row['password_wali'],
                 'siswa_id'=>$row['id']
                ]);
            }
        }
    }
}
