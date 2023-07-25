<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Support\Carbon;
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
            'link'=>null,
            'file'=>null,
            'mapel_id'=>2
        ]);

        Tugas::create([
            'id'=>'3',
            'nama_tugas'=>"Baca Tulis Al-Qur'an",
            'soal'=>'Bacalah surat Al-Kahfi ayat 1-20',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>7
        ]);

        Tugas::create([
            'id'=>'4',
            'nama_tugas'=>"Buat Aplikasi Kasir",
            'soal'=>'Desain boleh dikembangkan lagi sendiri',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>3
        ]);

        Tugas::create([
            'id'=>'5',
            'nama_tugas'=>"HTML CSS",
            'soal'=>'Lorem ipsum dolor sit amet.',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>1
        ]);

        Tugas::create([
            'id'=>'6',
            'nama_tugas'=>"Baca Tulis Al-Qur'an",
            'soal'=>'Bacalah surat Al-Kahfi ayat 1-20',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>9
        ]);

        Tugas::create([
            'id'=>'7',
            'nama_tugas'=>"Sejarah Kejayaan Islam",
            'soal'=>'Bagaimana peradaban Islam pada masa kejayaan ntara Tahun 650-1250 M',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>7
        ]);

        Tugas::create([
            'id'=>'8',
            'nama_tugas'=>"Mandi Wajib",
            'soal'=>'Jelaskan pengertian mandi wajib dalam islam, beserta tata caranya',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link'=>null,
            'file'=>null,
            'mapel_id'=>7
        ]);
        
    }
}
