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
           'nama_materi'=>'Wordpress',
           'tahun_ajaran'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'2',
            'nama_materi'=>'Sistem Reproduksi Manusia',
            'tahun_ajaran'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>5
        ]);

        Materi::create([
             'id'=>'3',
             'nama_materi'=>'Aljawir',
             'tahun_ajaran'=>'2023-05-05',
             'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
             'link'=>null,
             'file'=>null,
             'mapel_id'=>6
        ]);

        Materi::create([
            'id'=>'4',
            'nama_materi'=>'PHP Mysql',
            'tahun_ajaran'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>2
        ]);

        Materi::create([
            'id'=>'5',
           'nama_materi'=>'HTML & CSS',
           'tahun_ajaran'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'6',
           'nama_materi'=>'Sistem Tata Surya',
           'tahun_ajaran'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>5
        ]);
    }
}
