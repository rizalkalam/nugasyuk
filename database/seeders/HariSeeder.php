<?php

namespace Database\Seeders;

use App\Models\Hari;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hari::create([
            'id'=>'1',
            'hari'=>'Senin'
        ]);

        Hari::create([
            'id'=>'2',
            'hari'=>'Selasa'
        ]);

        Hari::create([
            'id'=>'3',
            'hari'=>'Rabu'
        ]);

        Hari::create([
            'id'=>'4',
            'hari'=>'Kamis'
        ]);

        Hari::create([
            'id'=>'5',
            'hari'=>"Jum'at"
        ]);

        Hari::create([
            'id'=>'6',
            'hari'=>'Sabtu'
        ]);
    }
}
