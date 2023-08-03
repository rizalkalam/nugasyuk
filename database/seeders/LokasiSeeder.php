<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Janjian::create([
            'id'=>'1',
            'tempat_konseling'=>'Ruang BK',
        ]);

        Janjian::create([
            'id'=>'2',
            'tempat_konseling'=>'Ruang Pesawat',
        ]);

        Janjian::create([
            'id'=>'3',
            'tempat_konseling'=>'Ruang VR',
        ]);

        Janjian::create([
            'id'=>'4',
            'tempat_konseling'=>'Perpustakaan',
        ]);

        Janjian::create([
            'id'=>'5',
            'tempat_konseling'=>'Perpustakaan Animasi',
        ]);

        Janjian::create([
            'id'=>'6',
            'tempat_konseling'=>'Studio Animasi',
        ]);
    }
}
