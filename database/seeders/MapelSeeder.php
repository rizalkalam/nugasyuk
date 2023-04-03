<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mapel::create([
            // 'id'=>'1',
           'kode_id'=>1,
           'kelas_id'=>1,
           'tugas_id'=>1,
           'materi_id'=>1,
        //    'nama_mapel'=>'ICT',
            // 'asset_id'=>1,
        ]);

        Mapel::create([
             // 'id'=>'1',
            'kode_id'=>2,
            'kelas_id'=>1,
            'tugas_id'=>2,
            'materi_id'=>2,
        //    'nama_mapel'=>'Science',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            // 'id'=>'1',
            'kode_id'=>3,
            'kelas_id'=>2,
            'tugas_id'=>3,
            'materi_id'=>3,
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);
    }
}
