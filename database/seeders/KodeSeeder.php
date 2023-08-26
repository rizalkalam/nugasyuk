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
           'nama_mapel'=>'Web Dev',
           'status_mapel'=>'produktif',
           'guru_id'=>1,
        ]);

        Kode::create([
             'id'=>'2',
           'kode_guru'=>'RH1',
           'nama_mapel'=>'IOT',
           'status_mapel'=>'produktif',
           'guru_id'=>2,
        ]);

        Kode::create([
            'id'=>'3',
            'kode_guru'=>'RH2',
            'nama_mapel'=>'Desktop Dev',
            'status_mapel'=>'produktif',
            'guru_id'=>2,
        ]);

        Kode::create([
             'id'=>'4',
            'kode_guru'=>'MA1',
            'nama_mapel'=>'Database',
            'status_mapel'=>'produktif',
            'guru_id'=>3,
        ]);

        Kode::create([
             'id'=>'5',
            'kode_guru'=>'LE1',
            'nama_mapel'=>'Bahasa Indonesia',
            'status_mapel'=>'normadaf',
            'guru_id'=>4,
        ]);

        Kode::create([
             'id'=>'6',
            'kode_guru'=>'IP1',
            'nama_mapel'=>'Sejarah',
            'status_mapel'=>'normadaf',
            'guru_id'=>5,
        ]);

        Kode::create([
             'id'=>'7',
            'kode_guru'=>'HC1',
            'nama_mapel'=>"PAI",
            'status_mapel'=>'normadaf',
            'guru_id'=>6,
        ]);

        Kode::create([
            'id'=>'8',
           'kode_guru'=>'SA1',
           'nama_mapel'=>"Bahasa Inggris",
           'status_mapel'=>'normadaf',
           'guru_id'=>7,
        ]);

        Kode::create([
            'id'=>'9',
           'kode_guru'=>'AR1',
           'nama_mapel'=>"Bimbingan Konseling",
           'status_mapel'=>'bk',
           'guru_id'=>8,
        ]);

        Kode::create([
            'id'=>'10',
           'kode_guru'=>'WI1',
           'nama_mapel'=>"Bimbingan Konseling",
           'status_mapel'=>'bk',
           'guru_id'=>9,
        ]);
    }
}
