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
            // 'id'=>'1',
           'judul'=>'Hosting Wordpres di 000 Webhost',
           'deadline'=>'2023-05-05',
           'status'=>1,
           'link'=>null,
           'file'=>null,
           'mapel_id'=>1
        ]);

        Tugas::create([
             // 'id'=>'1',
             'judul'=>'Buatlah makalah',
             'deadline'=>'2023-05-05',
             'status'=>1,
             'link'=>null,
             'file'=>null,
             'mapel_id'=>2
        ]);

        Tugas::create([
            // 'id'=>'1',
            'judul'=>'Penerapan Aljawir',
            'deadline'=>'2023-05-05',
            'status'=>1,
            'link'=>null,
            'file'=>null,
            'mapel_id'=>3
        ]);
    }
}
