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
            'nis'=>'0441',
            'nama_panggilan'=>'Kalam',
            'nama_siswa'=>'Khoiru Rizal Kalam Ismail',
            'email'=>'kalam@gmail.com',
            'password'=>bcrypt('kalam123'),
            'alamat'=>'Gunungkidul, Yogyakarta',
            'foto_profile'=>'gambar_profile_siswa/kalam.png',
            'kelas_id'=>1,
            // 'tugas_id'=>1
        ]);

        Murid::create([
            'id'=>'2',
            'nis'=>'0442',
            'nama_panggilan'=>'Zumar',
            'nama_siswa'=>'Muhammad Zumar Ramadhan',
            'email'=>'zumar@gmail.com',
            'password'=>bcrypt('zumar123'),
            'alamat'=>'Jati, Kudus',
            'foto_profile'=>'gambar_profile_siswa/zumar.png',
            'kelas_id'=>1,
            // 'tugas_id'=>3,
        ]);

        Murid::create([
            'id'=>'3',
            'nis'=>'0443',
            'nama_panggilan'=>'Wira',
            'nama_siswa'=>'Ahmad Aziz Wira Widodo',
            'email'=>'wirawdd@gmail.com',
            'password'=>bcrypt('wira123'),
            'alamat'=>'Perum Citra Kebun, RT.36, RW.11, Karawang, Jawa Barat',
            'foto_profile'=>'gambar_profile_siswa/wira.png',
            'kelas_id'=>1,
            // 'tugas_id'=>1,
        ]);

        
        Murid::create([
            'id'=>'4',
            'nis'=>'0444',
            'nama_panggilan'=>'Bimawan',
            'nama_siswa'=>'Muhammad Nur Wahid Bimawan',
            'email'=>'bimawan07@gmail.com',
            'password'=>bcrypt('bimawan123'),
            'alamat'=>'Sumbawa Barat, NTB',
            'foto_profile'=>'gambar_profile_siswa/bimawan.png',
            'kelas_id'=>1,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'5',
            'nis'=>'0445',
            'nama_panggilan'=>'Wahyu',
            'nama_siswa'=>'Muh Wahyu Ageng Pambudi',
            'email'=>'wahyu@gmail.com',
            'password'=>bcrypt('wahyu123'),
            'alamat'=>'Bae, Kudus',
            'foto_profile'=>'gambar_profile_siswa/wahyu.png',
            'kelas_id'=>2,
            // 'tugas_id'=>1,
        ]);

        // Murid::create([
        //     'id'=>'5',
        //     'nis'=>'0445',
        //     'nama_panggilan'=>'Wahyu',
        //     'nama_siswa'=>'Muh Wahyu Ageng Pambudi',
        //     'email'=>'wahyu@gmail.com',
        //     'password'=>bcrypt('wahyu123'),
        //     'alamat'=>'Bae, Kudus',
        //     'foto_profile'=>'gambar_profile_siswa/wahyu.png',
        //     'kelas_id'=>2,
        //     // 'tugas_id'=>1,
        // ]);
    }
}
