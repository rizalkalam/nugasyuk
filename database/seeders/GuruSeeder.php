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
        $guru = Guru::create([
            // 'id'=>'1',
            'nama_guru'=>'Joko Arianto',
            'email'=>'jokoarysbi@gmail.com',
            'password'=>bcrypt('mrjack123'),
            'niy'=>'0111',
            'foto_profile'=>'gambar1.jpg',
            'mapel_id'=>1,
            // 'role_id'=>2
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'2',
            'nama_guru'=>'Rizki Hidayat',
            'email'=>'rizkiganteng@gmail.com',
            'password'=>bcrypt('rizki123'),
            'niy'=>'0112',
            'foto_profile'=>'gambar2.jpg',
            'mapel_id'=>2,
            // 'mapel2_id'=>3
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'3',
            'nama_guru'=>'Musfiq Amrullah',
            'email'=>'mrmusfiq@gmail.com',
            'password'=>bcrypt('musfiq123'),
            'niy'=>'0113',
            'foto_profile'=>'gambar3.jpg',
            'mapel_id'=>4,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
             // 'id'=>'4',
             'nama_guru'=>'Lestari',
             'email'=>'estes@gmail.com',
             'password'=>bcrypt('estes123'),
             'niy'=>'0114',
             'foto_profile'=>'gambar3.jpg',
             'mapel_id'=>5,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'5',
            'nama_guru'=>'Isyana Putri',
            'email'=>'isyana@gmail.com',
            'password'=>bcrypt('isyana123'),
            'niy'=>'0115',
            'foto_profile'=>'gambar3.jpg',
            'mapel_id'=>6,
        ]);

        $guru->assignRole('guru_biasa');

        $guru = Guru::create([
            // 'id'=>'6'
            'nama_guru'=>'Hana Cinta Saraswati',
            'email'=>'heycinta@gmail.com',
            'password'=>bcrypt('cinta123'),
            'niy'=>'0116',
            'foto_profile'=>'gambar7.jpg',
            'mapel_id'=>7,
        ]);

        $guru->assignRole('guru_biasa');

        $bk = Guru::create([
            // 'id'=>'7',
            'nama_guru'=>'Sandita',
            'email'=>'sandita@gmail.com',
            'password'=>bcrypt('dita123'),
            'niy'=>'0117',
            'foto_profile'=>'gambar1.jpg',
            'mapel_id'=>8,
            // 'role_id'=>2
        ]);

        $bk->assignRole('guru_bk');
    }
}
