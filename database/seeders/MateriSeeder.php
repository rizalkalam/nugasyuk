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
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'tahun_mulai'=>'2023',
           'tahun_selesai'=>'2024',
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'2',
            'nama_materi'=>'Sistem Reproduksi Manusia',
            'tanggal_dibuat'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'tahun_mulai'=>'2023',
            'tahun_selesai'=>'2024',
            'mapel_id'=>5
        ]);

        Materi::create([
             'id'=>'3',
             'nama_materi'=>'Aljawir',
             'tanggal_dibuat'=>'2023-05-05',
             'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
             'link'=>null,
             'file'=>null,
             'tahun_mulai'=>'2023',
            'tahun_selesai'=>'2024',
             'mapel_id'=>6
        ]);

        Materi::create([
            'id'=>'4',
            'nama_materi'=>'PHP Mysql',
            'tanggal_dibuat'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>null,
            'file'=>null,
            'tahun_mulai'=>'2023',
            'tahun_selesai'=>'2024',
            'mapel_id'=>2
        ]);

        Materi::create([
            'id'=>'5',
           'nama_materi'=>'HTML & CSS',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'tahun_mulai'=>'2023',
           'tahun_selesai'=>'2024',
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'6',
           'nama_materi'=>'SQL Server',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'tahun_mulai'=>'2023',
           'tahun_selesai'=>'2024',
           'mapel_id'=>4
        ]);
        
        Materi::create([
            'id'=>'7',
           'nama_materi'=>'Arduino Uno',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>null,
           'file'=>null,
           'tahun_mulai'=>'2023',
           'tahun_selesai'=>'2024',
           'mapel_id'=>3
        ]);
    }
}
