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
            'id'=>'1',
            'kode_id'=>1,
            'kelas_id'=>1,
        //    'nama_mapel'=>'ICT',
            // 'asset_id'=>1,
        ]);

        Mapel::create([
            'id'=>'2',
            'kode_id'=>2,
            'kelas_id'=>1,
        //    'nama_mapel'=>'ICT',
            // 'asset_id'=>1,
        ]);

        Mapel::create([
            'id'=>'3',
            'kode_id'=>3,
            'kelas_id'=>1,
        //    'nama_mapel'=>'ICT',
            // 'asset_id'=>1,
        ]);

        Mapel::create([
            'id'=>'4',
            'kode_id'=>4,
            'kelas_id'=>1,
        //    'nama_mapel'=>'Science',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'5',
            'kode_id'=>5,
            'kelas_id'=>1,
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'6',
            'kode_id'=>6,
            'kelas_id'=>1,
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'7',
            'kode_id'=>7,
            'kelas_id'=>1,
            // 'nama_mapel'=>'Qur'an',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'8',
            'kode_id'=>6,
            'kelas_id'=>2,
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'9',
            'kode_id'=>7,
            'kelas_id'=>3,
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'10',
            'kode_id'=>8,
            'kelas_id'=>1,
            // 'status_mapel'=>'normadaf'
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);

        Mapel::create([
            'id'=>'11',
            'kode_id'=>9,
            'kelas_id'=>1,
            // 'status_mapel'=>'normadaf'
            // 'nama_mapel'=>'Math',
            // 'asset_id'=>2,
        ]);
    }
}
