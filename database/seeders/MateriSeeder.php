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
            // 'id'=>'1',
           'judul'=>'Hosting Wordpress',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);

        Materi::create([
            // 'id'=>'1',
            'judul'=>'Sistem Reproduksi Manusia',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>2
        ]);

        Materi::create([
             // 'id'=>'1',
             'judul'=>'Ajawir',
             'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
             'link'=>null,
             'file'=>null,
             'mapel_id'=>3
        ]);
    }
}
