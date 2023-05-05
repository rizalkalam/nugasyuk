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
            'kode_id'=>1,
            // 'kelas_id'=>1
        ]);
    }
}
