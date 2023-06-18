<?php

namespace Database\Seeders;

use App\Models\Tingkatan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TingkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tingkatan::create([
            // 'id'=>'1',
           'tingkat_ke'=>'10'
        ]);

        Tingkatan::create([
            // 'id'=>'2',
            'tingkat_ke'=>'11'
        ]);

        Tingkatan::create([
            // 'id'=>'2',
            'tingkat_ke'=>'12'
        ]);
    }
}
