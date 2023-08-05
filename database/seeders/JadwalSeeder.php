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
            'hari_id'=>2,
            'jam_id'=>1,
            'mapel_id'=>2
        ]);

        Jadwal::create([
            'id'=>'3',
            'hari_id'=>3,
            'jam_id'=>1,
            'mapel_id'=>4
        ]);

        Jadwal::create([
            'id'=>'4',
            'hari_id'=>4,
            'jam_id'=>1,
            'mapel_id'=>1
        ]);

        Jadwal::create([
            'id'=>'5',
            'hari_id'=>5,
            'jam_id'=>1,
            'mapel_id'=>3
        ]);

        Jadwal::create([
            'id'=>'6',
            'hari_id'=>6,
            'jam_id'=>1,
            'mapel_id'=>4
        ]);

        Jadwal::create([
            'id'=>'7',
            'hari_id'=>2,
            'jam_id'=>1,
            'mapel_id'=>4
        ]);

        Jadwal::create([
            'id'=>'8',
            'hari_id'=>1,
            'jam_id'=>2,
            'mapel_id'=>7
        ]);

        Jadwal::create([
            'id'=>'9',
            'hari_id'=>5,
            'jam_id'=>1,
            'mapel_id'=>9
        ]);

        Jadwal::create([
            'id'=>'10',
            'hari_id'=>2,
            'jam_id'=>1,
            'mapel_id'=>8
        ]);

        Jadwal::create([
            'id'=>'11',
            'hari_id'=>3,
            'jam_id'=>1,
            'mapel_id'=>8
        ]);

        Jadwal::create([
            'id'=>'12',
            'hari_id'=>4,
            'jam_id'=>1,
            'mapel_id'=>8
        ]);

        Jadwal::create([
            'id'=>'13',
            'hari_id'=>5,
            'jam_id'=>1,
            'mapel_id'=>8
        ]);

        Jadwal::create([
            'id'=>'14',
            'hari_id'=>6,
            'jam_id'=>1,
            'mapel_id'=>8
        ]);

        Jadwal::create([
            'id'=>'15',
            'hari_id'=>6,
            'jam_id'=>3,
            'mapel_id'=>7
        ]);

        Jadwal::create([
            'id'=>'16',
            'hari_id'=>6,
            'jam_id'=>4,
            'mapel_id'=>7
        ]);
    }
}
