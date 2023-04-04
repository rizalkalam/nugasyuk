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
            // 'id'=>'1',
           'kode_guru'=>'JA1',
           'nama_mapel'=>'ICT',
           'guru_id'=>1,
        ]);

        Kode::create([
             // 'id'=>'1',
           'kode_guru'=>'MF1',
           'nama_mapel'=>'Science',
           'guru_id'=>2,
        ]);

        Kode::create([
            // 'id'=>'1',
            'kode_guru'=>'MF2',
            'nama_mapel'=>'Math',
            'guru_id'=>2,
        ]);
    }
}
