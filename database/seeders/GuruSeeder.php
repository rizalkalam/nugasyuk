<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::create([
            // 'id'=>'1',
            'nama_guru'=>'Joko Arianto',
            'email'=>'jokoarysbi@gmail.com',
            'password'=>bcrypt('mrjack123'),
            'niy'=>'0111',
            'foto_profile'=>'gambar1.jpg',
            'mapel_id'=>1
        ]);

        Guru::create([
            // 'id'=>'2',
            'nama_guru'=>'Musfiq Amrullah',
            'email'=>'musfiqa@gmail.com',
            'password'=>bcrypt('mrmusfiq123'),
            'niy'=>'0112',
            'foto_profile'=>'gambar2.jpg',
            'mapel_id'=>5,
            // 'mapel2_id'=>3
        ]);
    }
}
