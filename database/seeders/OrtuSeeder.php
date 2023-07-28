<?php

namespace Database\Seeders;

use App\Models\Ortu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrtuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ortu::create([
            // 'id'=>'1',
            'nama'=>'Hermanto',
            'email'=>'hermannn19@gmail.com',
            'password'=>bcrypt('herman123'),
            'siswa_id'=>1
        ]);

        Ortu::create([
            // 'id'=>'2',
            'nama'=>'Sri Ningsih',
            'email'=>'busri33@gmail.com',
            'password'=>bcrypt('busri123'),
            'siswa_id'=>2
        ]);

        Ortu::create([
            'nama'=>'Didit Hartanto',
            'email'=>'didit@gmail.com',
            'password'=>bcrypt('didit123'),
            'siswa_id'=>3
        ]);

        Ortu::create([
            'nama'=>'Nugroho Santoso',
            'email'=>'nugroho@gmail.com',
            'password'=>bcrypt('nugroho123'),
            'siswa_id'=>4
        ]);

        Ortu::create([
            'nama'=>'Firmansyah',
            'email'=>'firman@gmail.com',
            'password'=>bcrypt('firman123'),
            'siswa_id'=>5
        ]);

        Ortu::create([
            'nama'=>'Ardian',
            'email'=>'ardian@gmail.com',
            'password'=>bcrypt('ardian123'),
            'siswa_id'=>6
        ]);

        Ortu::create([
            'nama'=>'Siti',
            'email'=>'siti@gmail.com',
            'password'=>bcrypt('siti123'),
            'siswa_id'=>7
        ]);
    }
}
