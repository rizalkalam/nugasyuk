<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tugas::create([
            'id'=>'1',
            'nama_tugas'=>'Wordpress',
            'soal'=>'Hosting Wordpres di 000 Webhost',
            'date'=>'2023-05-04',
            'deadline'=>'2023-05-05',
            'description'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            // 'status'=>1,
            'link'=>null,
            'file'=>null,
            'mapel_id'=>'1'
            // 'materi_id'=>1
        ]);

        Tugas::create([
            'id'=>'2',
            'nama_tugas'=>'Arduino Uno',
            'soal'=>'Cek Suhu',
            'date'=>'2023-05-04',
            'deadline'=>'2023-05-05',
            'description'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
            // 'status'=>1,
            'link'=>null,
            'file'=>null,
            'mapel_id'=>2
        ]);

        Tugas::create([
            'id'=>'3',
            'nama_tugas'=>"Baca Tulis Al-Qur'an",
            'soal'=>'Bacalah surat Al-Kahfi ayat 1-20',
            'date'=>'2023-05-04',
            'deadline'=>'2023-05-05',
            'description'=>'Berikan bukti video saat membaca',
            // 'status'=>1,
            'link'=>null,
            'file'=>null,
            'mapel_id'=>7
        ]);

        // Tugas::create([
        //     'id'=>'2',
        //     'soal'=>'Penerapan Aljawir',
        //     'date'=>'2023-05-04',
        //     'deadline'=>'2023-05-05',
        //     'description'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
        //     // 'status'=>1,
        //     'link'=>null,
        //     'file'=>null,
        //     'materi_id'=>3
        // ]);

        // Tugas::create([
        //     'id'=>'3',
        //     'soal'=>'Website Landing Page',
        //     'date'=>'2023-05-04',
        //     'deadline'=>'2023-04-05',
        //     'description'=>'lorem ipsum dolor sit amet bla bli blu ble blo ohok ohok',
        //     // 'status'=>2,
        //     'link'=>null,
        //     'file'=>null,
        //     'materi_id'=>1
        // ]);
    }
}
