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
            // 'id'=>'1',
           'nama_jurusan'=>'Animasi'
        ]);

        Jurusan::create([
            // 'id'=>'1',
           'nama_jurusan'=>'DKV'
        ]);
    }
}
