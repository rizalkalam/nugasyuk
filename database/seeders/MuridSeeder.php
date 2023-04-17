<?php

namespace Database\Seeders;

use App\Models\Murid;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Murid::create([
            'id'=>'1',
            'nama_siswa'=>'kalam',
            'email'=>'kalam@gmail.com',
            'password'=>bcrypt('kalam123'),
            // 'nis'=>'0441',
            'foto_profile'=>'gambar1.jpg',
            'kelas_id'=>1,
            // 'tugas_id'=>1
        ]);

        Murid::create([
            'id'=>'2',
            'nama_siswa'=>'zumar',
            'email'=>'zumar@gmail.com',
            'password'=>bcrypt('zumar123'),
            // 'nis'=>'0442',
            'foto_profile'=>'gambar1.jpg',
            'kelas_id'=>1,
            // 'tugas_id'=>3,
        ]);

        Murid::create([
            'id'=>'3',
            'nama_siswa'=>'wira',
            'email'=>'wirawdd@gmail.com',
            'password'=>bcrypt('wira123'),
            // 'nis'=>'0444',
            'foto_profile'=>'gambar1.jpg',
            'kelas_id'=>1,
            // 'tugas_id'=>1,
        ]);

        
        // Murid::create([
        //     // 'id'=>'2',
        //     'nama_siswa'=>'bimawan',
        //     'email'=>'bimawan07@gmail.com',
        //     'password'=>bcrypt('bimawan123'),
        //     // 'nis'=>'0443',
        //     'foto_profile'=>'gambar1.jpg',
        //     'kelas_id'=>1,
        //     // 'tugas_id'=>1,
        // ]);
    }
}
