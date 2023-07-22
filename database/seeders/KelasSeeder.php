<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kelas::create([
        //     // 'id'=>'1',
        //    'nama_kelas'=>'1',
        //    'jumlah_siswa'=>30,
        //    'tingkatan_id'=>1,
        //    'jurusan_id'=>1
        // ]);

        // Kelas::create([
        //     // 'id'=>'1',
        //    'nama_kelas'=>'2',
        //    'jumlah_siswa'=>32,
        //    'tingkatan_id'=>1,
        //    'jurusan_id'=>1
        // ]);

        // Kelas::create([
        //     // 'id'=>'1',
        //    'nama_kelas'=>'1',
        //    'jumlah_siswa'=>34,
        //    'tingkatan_id'=>2,
        //    'jurusan_id'=>1
        // ]);

        // Kelas::create([
        //     // 'id'=>'1',
        //    'nama_kelas'=>'2',
        //    'jumlah_siswa'=>35,
        //    'tingkatan_id'=>2,
        //    'jurusan_id'=>1
        // ]);

        // Kelas::create([
        //     // 'id'=>'1',
        //     'nama_kelas'=>'1',
        //     'jumlah_siswa'=>34,
        //     'tingkatan_id'=>1,
        //     'jurusan_id'=>2
        // ]);

        // Kelas::create([
        //     // 'id'=>'1',
        //     'nama_kelas'=>'1',
        //     'jumlah_siswa'=>31,
        //     'tingkatan_id'=>1,
        //     'jurusan_id'=>3
        // ]);

        collect([
            [
                // 1
                'nama_kelas'=>'1',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>1,
                'jurusan_id'=>1,
                'guru_id'=>1
            ],

            [
                // 2
                'nama_kelas'=>'2',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>1,
                'jurusan_id'=>1,
                'guru_id'=>2
            ],

            [
                // 3
                'nama_kelas'=>'1',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>1,
                'jurusan_id'=>2,
                'guru_id'=>3
            ],

            [
                // 4
                'nama_kelas'=>'2',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>1,
                'jurusan_id'=>2,
                'guru_id'=>4
            ],

            [
                // 5
                'nama_kelas'=>'1',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>1,
                'jurusan_id'=>3,
                'guru_id'=>5
            ],

            [
                // 6
                'nama_kelas'=>'1',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>2,
                'jurusan_id'=>1,
                'guru_id'=>7
            ],

            [
                // 7
                'nama_kelas'=>'2',
                // 'jumlah_siswa'=>'30',
                'tingkatan_id'=>2,
                'jurusan_id'=>1,
                'guru_id'=>8
            ],

        ])->each(function ($kelas){
            DB::table('kelas')->insert($kelas);
        });
    }
}
