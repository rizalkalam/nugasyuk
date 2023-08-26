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
            'password'=>bcrypt('2023_Hermanto_0441'),
            'siswa_id'=>1
        ]);

        Ortu::create([
            // 'id'=>'2',
            'nama'=>'Sri Ningsih',
            'email'=>'sriningsih@gmail.com',
            'password'=>bcrypt('2023_Sri_0442'),
            'siswa_id'=>2
        ]);

        Ortu::create([
            'nama'=>'Didit Hartanto',
            'email'=>'didit@gmail.com',
            'password'=>bcrypt('2023_Didit_0443'),
            'siswa_id'=>3
        ]);

        Ortu::create([
            'nama'=>'Nugroho Santoso',
            'email'=>'nugroho@gmail.com',
            'password'=>bcrypt('2023_Nugroho_0444'),
            'siswa_id'=>4
        ]);

        Ortu::create([
            'nama'=>'Firmansyah',
            'email'=>'firman@gmail.com',
            'password'=>bcrypt('2023_Firmansyah_0445'),
            'siswa_id'=>5
        ]);

        Ortu::create([
            'nama'=>'Ardian',
            'email'=>'ardian@gmail.com',
            'password'=>bcrypt('2023_Ardian_0450'),
            'siswa_id'=>6
        ]);

        Ortu::create([
            'nama'=>'Siti',
            'email'=>'siti@gmail.com',
            'password'=>bcrypt('2023_Siti_0451'),
            'siswa_id'=>7
        ]);

        Ortu::create([
            'nama'=>'Riyan',
            'email'=>'riyan@gmail.com',
            'password'=>bcrypt('2023_Ryan_0458'),
            'siswa_id'=>8
        ]);

        Ortu::create([
            'nama'=>'Dani',
            'email'=>'dani@gmail.com',
            'password'=>bcrypt('2023_Dani_0459'),
            'siswa_id'=>9
        ]);

        Ortu::create([
            'nama'=>'Rini',
            'email'=>'rini@gmail.com',
            'password'=>bcrypt('2023_Rini_0460'),
            'siswa_id'=>10
        ]);
    }
}
