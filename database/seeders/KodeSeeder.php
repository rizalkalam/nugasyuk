<?php

namespace Database\Seeders;

use App\Models\Kode;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kode::create([
            'id'=>'1',
           'kode_guru'=>'JA1',
           'nama_mapel'=>'Web Programming',
           'guru_id'=>1,
        ]);

        Kode::create([
             'id'=>'2',
           'kode_guru'=>'RZ1',
           'nama_mapel'=>'IOT',
           'guru_id'=>2,
        ]);

        Kode::create([
            'id'=>'3',
            'kode_guru'=>'RZ2',
            'nama_mapel'=>'Desktop',
            'guru_id'=>2,
        ]);

        Kode::create([
             'id'=>'4',
            'kode_guru'=>'MF1',
            'nama_mapel'=>'Database',
            'guru_id'=>3,
        ]);

        Kode::create([
             'id'=>'5',
            'kode_guru'=>'LS1',
            'nama_mapel'=>'Bahasa Indonesia',
            'guru_id'=>4,
        ]);

        Kode::create([
             'id'=>'6',
            'kode_guru'=>'IP1',
            'nama_mapel'=>'Sejarah',
            'guru_id'=>5,
        ]);

        Kode::create([
             'id'=>'7',
            'kode_guru'=>'HS1',
            'nama_mapel'=>"Baca Tulis Al-Qur'an",
            'guru_id'=>6,
        ]);

        Kode::create([
            'id'=>'8',
           'kode_guru'=>'DT1',
           'nama_mapel'=>"Bahasa Inggris",
           'guru_id'=>7,
        ]);

        Kode::create([
            'id'=>'9',
           'kode_guru'=>'AN1',
           'nama_mapel'=>"Bimbingan Konseling",
           'guru_id'=>8,
        ]);
    }
}
