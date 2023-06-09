<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jadwal::create([
            'id'=>'1',
            'hari_id'=>1,
            'jam_id'=>1,
            'mapel_id'=>1
        ]);

        Jadwal::create([
            'id'=>'2',
            'hari_id'=>1,
            'jam_id'=>2,
            'mapel_id'=>3
        ]);

        Jadwal::create([
            'id'=>'3',
            'hari_id'=>1,
            'jam_id'=>3,
            'mapel_id'=>4
        ]);
    }
}
