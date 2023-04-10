<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::create([
            'id'=>'1',
           'judul'=>'Hosting Wordpress',
           'date'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'2',
            'judul'=>'Sistem Reproduksi Manusia',
            'date'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>5
        ]);

        Materi::create([
             'id'=>'3',
             'judul'=>'Aljawir',
             'date'=>'2023-05-05',
             'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
             'link'=>null,
             'file'=>null,
             'mapel_id'=>6
        ]);

        Materi::create([
            'id'=>'4',
            'judul'=>'Wordpress Landing Page',
            'date'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>2
        ]);

        Materi::create([
            'id'=>'5',
           'judul'=>'Coba',
           'date'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);
    }
}
