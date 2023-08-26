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
            'password'=>bcrypt('2023_Khoiru_0441'),
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
            'password'=>bcrypt('2023_Muhammad_Zumar_0442'),
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
            'password'=>bcrypt('2023_Ahmad_0443'),
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
            'password'=>bcrypt('2023_Muhammad_Nur_0444'),
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
            'password'=>bcrypt('2023_Muh_Wahyu_0445'),
            'alamat'=>'Bae, Kudus',
            'foto_profile'=>'gambar_profile_siswa/wahyu.png',
            'kelas_id'=>2,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'6',
            'nis'=>'0450',
            'nama_panggilan'=>'Gavra',
            'nama_siswa'=>'Javier Gavra Abhinaya',
            'email'=>'gavra@gmail.com',
            'password'=>bcrypt('2023_Javier_0450'),
            'alamat'=>'Dawe, Kudus',
            'foto_profile'=>'gambar_profile_siswa/javier.png',
            'kelas_id'=>3,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'7',
            'nis'=>'0451',
            'nama_panggilan'=>'Syahda',
            'nama_siswa'=>'Solana Syahda Rahendra',
            'email'=>'syahdude@gmail.com',
            'password'=>bcrypt('2023_Solana_0451'),
            'alamat'=>'Surakarta',
            'foto_profile'=>'gambar_profile_siswa/syahda.jpg',
            'kelas_id'=>3,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'8',
            'nis'=>'0458',
            'nama_panggilan'=>'Rifda',
            'nama_siswa'=>'Rifda Nalil Hana',
            'email'=>'rifdahhh@gmail.com',
            'password'=>bcrypt('2023_Rifda_0458'),
            'alamat'=>'Wonogiri',
            'foto_profile'=>'gambar_profile_siswa/rifda.png',
            'kelas_id'=>3,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'9',
            'nis'=>'0459',
            'nama_panggilan'=>'Aul',
            'nama_siswa'=>'Tsaqifah Aulia',
            'email'=>'tsaqifaulia@gmail.com',
            'password'=>bcrypt('2023_Tsaqifah_0459'),
            'alamat'=>'Surakarta',
            'foto_profile'=>'gambar_profile_siswa/tsaqifa.png',
            'kelas_id'=>4,
            // 'tugas_id'=>1,
        ]);

        Murid::create([
            'id'=>'10',
            'nis'=>'0460',
            'nama_panggilan'=>'Zalva',
            'nama_siswa'=>'Aulia Zalva Prawesti',
            'email'=>'zalvaa@gmail.com',
            'password'=>bcrypt('2023_Aulia_0460'),
            'alamat'=>'Surakarta',
            'foto_profile'=>'gambar_profile_siswa/zalva.png',
            'kelas_id'=>5,
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
