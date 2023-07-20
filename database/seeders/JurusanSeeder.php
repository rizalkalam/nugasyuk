<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            // 'id'=>'1',
           'nama_jurusan'=>'PPLG'
        ]);

        Jurusan::create([
            // 'id'=>'2',
           'nama_jurusan'=>'Animasi'
        ]);

        Jurusan::create([
            // 'id'=>'3',
           'nama_jurusan'=>'DKV'
        ]);

        Jurusan::create([
            // 'id'=>'4',
           'nama_jurusan'=>'DG'
        ]);

        Jurusan::create([
            // 'id'=>'5',
           'nama_jurusan'=>'Teknik Grafika'
        ]);
    }
}
