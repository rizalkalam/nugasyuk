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
            // untuk kelas id 1
            'id'=>'1',
            'nama_tugas'=>'Wordpress',
            'soal'=>'Hosting Wordpres di 000 Webhost',
            'date'=>'2023-05-04',
            'deadline'=>'2023-08-17',
            'link_tugas'=>'https://youtu.be/Vgt1d3eAm7A',
            'file_tugas'=>null,
            'mapel_id'=>'1',
            'input_jawaban'=> 'tidak'
        ]);

        Tugas::create([
            'id'=>'2',
            'nama_tugas'=>'Arduino Uno',
            'soal'=>'Cek Suhu',
            'date'=>'2023-05-04',
            'deadline'=>'2023-05-05',
            'link_tugas'=>null,
            'file_tugas'=>'file/data_kuis_app.xlsx',
            'mapel_id'=>2,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            // untuk kelas id 1
            'id'=>'3',
            'nama_tugas'=>"Baca Tulis Al-Qur'an",
            'soal'=>'Bacalah surat Al-Kahfi ayat 1-20',
            'date'=>Carbon::yesterday()->format('Y-m-d'),
            'deadline'=>'2023-09-25',
            'link_tugas'=>null,
            'file_tugas'=>'file/data_kuis_app.xlsx',
            'mapel_id'=>7,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            'id'=>'4',
            'nama_tugas'=>"Buat Aplikasi Kasir",
            'soal'=>'Desain boleh dikembangkan lagi sendiri',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-07-10',
            'link_tugas'=>null,
            'file_tugas'=>'file/data_kuis_app.xlsx',
            'mapel_id'=>3,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            // untuk kelas id 1
            'id'=>'5',
            'nama_tugas'=>"HTML CSS",
            'soal'=>'Buatlah website landing page dengan tema bebas',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-08-15',
            'link_tugas'=>null,
            'file_tugas'=>'file/data_kuis_app.xlsx',
            'mapel_id'=>1,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            'id'=>'6',
            'nama_tugas'=>"Baca Tulis Al-Qur'an",
            'soal'=>'Bacalah surat Al-Kahfi ayat 1-20',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-09-10',
            'link_tugas'=>null,
            'file_tugas'=>'file/1691078749-Memperkuat Keimanan.pdf',
            'mapel_id'=>9,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            // untuk kelas id 1
            'id'=>'7',
            'nama_tugas'=>"Sejarah Kejayaan Islam",
            'soal'=>'Bagaimana peradaban Islam pada masa kejayaan ntara Tahun 650-1250 M',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-09-10',
            'link_tugas'=>'https://youtu.be/Vgt1d3eAm7A',
            'file_tugas'=>'file/1691078712-MAKALAH.docx',
            'mapel_id'=>7,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            'id'=>'8',
            'nama_tugas'=>"Mandi Wajib",
            'soal'=>'Jelaskan pengertian mandi wajib dalam islam, beserta tata caranya',
            'date'=>Carbon::now()->format('Y-m-d'),
            'deadline'=>'2023-09-10',
            'link_tugas'=>'https://youtu.be/Vgt1d3eAm7A',
            'file_tugas'=>null,
            'mapel_id'=>9,
            'input_jawaban'=> 'ya'
        ]);

        Tugas::create([
            'id'=>'9',
            'nama_tugas'=>"BPUPKI",
            'soal'=>'Ceritakan dan jelaskan sejarah Pembentukan BPUPKI dan PPKI, beserta anggota dan latarbelakang pembentukannya',
            'date'=>'2023-08-19',
            'deadline'=>'2023-09-27',
            'link_tugas'=>'https://youtu.be/Vgt1d3eAm7A',
            'file_tugas'=>null,
            'mapel_id'=>6,
            'input_jawaban'=> 'tidak'
        ]);
        
    }
}
