<?php

namespace Database\Seeders;

use App\Models\Pengumpulan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengumpulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumpulan::create([
            'id'=>1,
            'tugas_id'=>1,
            'status'=>'selesai',
            'murid_id'=>1
        ]);

        Pengumpulan::create([
            'id'=>2,
            'tugas_id'=>3,
            'status'=>'belum selesai',
            'murid_id'=>1
        ]);

        Pengumpulan::create([
            'id'=>3,
            'tugas_id'=>1,
            'status'=>'selesai',
            'murid_id'=>2
        ]);

        Pengumpulan::create([
            'id'=>4,
            'tugas_id'=>3,
            'status'=>'selesai',
            'murid_id'=>2
        ]);

        Pengumpulan::create([
            'id'=>5,
            'tugas_id'=>1,
            'status'=>'belum selesai',
            'murid_id'=>3
        ]);

        Pengumpulan::create([
            'id'=>6,
            'tugas_id'=>1,
            'status'=>'belum selesai',
            'murid_id'=>4
        ]);
    }
}
