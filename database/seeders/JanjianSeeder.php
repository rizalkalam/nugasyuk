<?php

namespace Database\Seeders;

use App\Models\Janjian;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JanjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Janjian::create([
            'id'=>'1',
            'guru_id'=>'8',
            'murid_id'=>'1',
            'jam_id'=>'1',
            'lokasi_id'=>'1',
            'topik'=>'Kuliah setelah SMK',
            'tanggal'=>Carbon::now()->format('Y-m-d')
        ]);

        Janjian::create([
            'id'=>'2',
            'guru_id'=>'8',
            'murid_id'=>'2',
            'jam_id'=>'2',
            'topik'=>'Kuliah setelah SMK',
            'lokasi_id'=>'1',
            'tanggal'=>Carbon::now()->format('Y-m-d')
        ]);

        Janjian::create([
            'id'=>'3',
            'guru_id'=>'8',
            'murid_id'=>'3',
            'jam_id'=>'3',
            'topik'=>'Kerja setelah lulus SMK',
            'lokasi_id'=>'1',
            'tanggal'=>Carbon::now()->format('Y-m-d')
        ]);

        Janjian::create([
            'id'=>'4',
            'guru_id'=>'8',
            'murid_id'=>'4',
            'jam_id'=>'5',
            'lokasi_id'=>'2',
            'topik'=>'Pengen gantiin ronaldo',
            'tanggal'=>Carbon::now()->format('Y-m-d')
        ]);
    }
}
