<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Support\Carbon;
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
        //    'tahun_mulai'=>'2023',
        //    'tahun_selesai'=>'2024',
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'2',
            'nama_materi'=>'Sistem Reproduksi Manusia',
            'tanggal_dibuat'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>"https://youtu.be/aiKw24xS2Xg",
            'file'=>null,
            // 'tahun_mulai'=>'2023',
            // 'tahun_selesai'=>'2024',
            'mapel_id'=>5
        ]);

        Materi::create([
             'id'=>'3',
             'nama_materi'=>'Aljawir',
             'tanggal_dibuat'=>'2023-05-05',
             'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
             'link'=>"https://youtu.be/aiKw24xS2Xg",
             'file'=>null,
            //  'tahun_mulai'=>'2023',
            // 'tahun_selesai'=>'2024',
             'mapel_id'=>6
        ]);

        Materi::create([
            'id'=>'4',
            'nama_materi'=>'PHP Mysql',
            'tanggal_dibuat'=>'2023-05-05',
            'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            'link'=>"https://youtu.be/aiKw24xS2Xg",
            'file'=>null,
            // 'tahun_mulai'=>'2023',
            // 'tahun_selesai'=>'2024',
            'mapel_id'=>2
        ]);

        Materi::create([
            'id'=>'5',
           'nama_materi'=>'HTML & CSS',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>"https://www.w3schools.com/",
           'file'=>null,
        //    'tahun_mulai'=>'2023',
        //    'tahun_selesai'=>'2024',
           'mapel_id'=>1
        ]);

        Materi::create([
            'id'=>'6',
           'nama_materi'=>'SQL Server',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>"https://www.w3schools.com/",
           'file'=>null,
        //    'tahun_mulai'=>'2023',
        //    'tahun_selesai'=>'2024',
           'mapel_id'=>4
        ]);
        
        Materi::create([
            'id'=>'7',
           'nama_materi'=>'Arduino Uno',
           'tanggal_dibuat'=>'2023-05-05',
           'isi'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
           'link'=>"https://www.w3schools.com/",
           'file'=>null,
        //    'tahun_mulai'=>'2023',
        //    'tahun_selesai'=>'2024',
           'mapel_id'=>3
        ]);

        Materi::create([
            'id'=>'8',
            'nama_materi'=>"Keutamaan membaca Al-Qur'an",
            'isi'=>'lorem ipsum dolor sit amet',
            'tanggal_dibuat'=>Carbon::yesterday()->format('Y-m-d'),
            // 'tahun_mulai'=>'2022',
            // 'tahun_selesai'=>'2023',
            'link'=>"https://youtu.be/9OQBDdNHmXo",
            'file'=>"file/1691078712-MAKALAH.docx",
            'mapel_id'=>7
        ]);

        Materi::create([
            'id'=>'9',
            'nama_materi'=>'Keimanan',
            'isi'=>'lorem ipsum dolor sit amet',
            'tanggal_dibuat'=>Carbon::now()->format('Y-m-d'),
            // 'tahun_mulai'=>'2022',
            // 'tahun_selesai'=>'2023',
            'link'=>null,
            'file'=>"file/1691078749-Memperkuat Keimanan.pdf",
            'mapel_id'=>7
        ]);

        Materi::create([
            'id'=>'10',
            'nama_materi'=>'Beriman kepada hari akhir',
            'isi'=>'lorem ipsum dolor sit amet',
            'tanggal_dibuat'=>Carbon::now()->format('Y-m-d'),
            // 'tahun_mulai'=>'2022',
            // 'tahun_selesai'=>'2023',
            'link'=>"https://youtu.be/9OQBDdNHmXo",
            'file'=>null,
            'mapel_id'=>7
        ]);
    }
}
