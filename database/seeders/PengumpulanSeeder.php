<?php

namespace Database\Seeders;

use App\Models\Pengumpulan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengumpulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumpulan::create([
            'id'=>1,
            'tugas_id'=>1,
            'status'=>'menunggu_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>2,
            'tugas_id'=>1,
            'status'=>'belum_selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>3,
            'tugas_id'=>1,
            'status'=>'belum_selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>3,
            'tanggal'=>'2023-04-04'
        ]);

        Pengumpulan::create([
            'id'=>4,
            'tugas_id'=>1,
            'status'=>'menunggu_dalam_deadline',
            // 'kelas_id'=>2,
            'murid_id'=>4,
            'tanggal'=>'2023-04-04',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>5,
            'tugas_id'=>3,
            'status'=>'menunggu_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>6,
            'tugas_id'=>3,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>7,
            'tugas_id'=>3,
            'status'=>'selesai_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>3,
            'tanggal'=>'2023-04-04',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>8,
            'tugas_id'=>3,
            'status'=>'selesai_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>4,
            'tanggal'=>'2023-04-04',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>9,
            'tugas_id'=>5,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-04-04',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>10,
            'tugas_id'=>5,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>3,
            'tanggal'=>'2023-04-04',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>11,
            'tugas_id'=>6,
            'status'=>'menunggu_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>5,
            'tanggal'=>'2023-07-11',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>12,
            'tugas_id'=>6,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>6,
            'tanggal'=>'2023-04-04',
            'file' => 'file/data_kuis_app',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>13,
            'tugas_id'=>7,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>1,
            'tanggal'=>'2023-04-04',
            'file' => 'file/1691078749-Memperkuat Keimanan.pdf',
            'link' => null,
        ]);

        Pengumpulan::create([
            'id'=>14,
            'tugas_id'=>7,
            'status'=>'menunggu_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>2,
            'tanggal'=>'2023-07-012',
            'file' => 'file/1691078712-MAKALAH.docx',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>15,
            'tugas_id'=>7,
            'status'=>'selesai_dalam_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>3,
            'tanggal'=>'2023-04-04',
            'file' => null,
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>16,
            'tugas_id'=>7,
            'status'=>'selesai_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>4,
            'tanggal'=>'2023-04-04',
            'file' => 'file/1691078749-Memperkuat Keimanan.pdf',
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);

        Pengumpulan::create([
            'id'=>17,
            'tugas_id'=>8,
            'status'=>'selesai_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>5,
            'tanggal'=>'2023-04-04',
            'file' => 'file/1691078749-Memperkuat Keimanan.pdf',
            'link' => null,
        ]);

        Pengumpulan::create([
            'id'=>18,
            'tugas_id'=>8,
            'status'=>'selesai_lebih_deadline',
            // 'kelas_id'=>1,
            'murid_id'=>6,
            'tanggal'=>'2023-04-04',
            'file' => null,
            'link' => 'https://youtu.be/Vgt1d3eAm7A',
        ]);
    }
}
