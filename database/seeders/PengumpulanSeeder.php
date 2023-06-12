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
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>2,
            'tugas_id'=>2,
            'status'=>'belum_selesai',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>3,
            'tugas_id'=>1,
            'status'=>'selesai',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>4,
            'tugas_id'=>1,
            'status'=>'belum_selesai',
            // 'kelas_id'=>2,
            'murid_id'=>3,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>5,
            'tugas_id'=>3,
            'status'=>'belum_selesai',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>6,
            'tugas_id'=>3,
            'status'=>'selesai',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>7,
            'tugas_id'=>2,
            'status'=>'selesai',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>8,
            'tugas_id'=>2,
            'status'=>'selesai',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04'
        ]);

        // Pengumpulan::create([
        //     'id'=>2,
        //     'tugas_id'=>3,
        //     'status'=>'belum selesai',
        //     // 'murid_id'=>1
        // ]);

        // Pengumpulan::create([
        //     'id'=>3,
        //     'tugas_id'=>1,
        //     'status'=>'selesai',
        //     // 'murid_id'=>2
        // ]);

        // Pengumpulan::create([
        //     'id'=>4,
        //     'tugas_id'=>3,
        //     'status'=>'selesai',
        //     // 'murid_id'=>2
        // ]);

        // Pengumpulan::create([
        //     'id'=>5,
        //     'tugas_id'=>1,
        //     'status'=>'belum selesai',
        //     // 'murid_id'=>3
        // ]);

        // Pengumpulan::create([
        //     'id'=>6,
        //     'tugas_id'=>1,
        //     'status'=>'belum selesai',
        //     // 'murid_id'=>4
        // ]);

        // Pengumpulan::create([
        //     'id'=>7,
        //     'tugas_id'=>2,
        //     'status'=>'belum selesai',
        //     // 'murid_id'=>3
        // ]);

        // Pengumpulan::create([
        //     'id'=>8,
        //     'tugas_id'=>2,
        //     'status'=>'selesai',
        //     // 'murid_id'=>1
        // ]);
    }
}
