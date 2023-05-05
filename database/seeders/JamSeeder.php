<?php

namespace Database\Seeders;

use App\Models\Jam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jam::create([
            'id'=>'1',
            'waktu_mulai'=>'07:00',
            'waktu_selesai'=>'07:40',
        ]);

        Jam::create([
            'id'=>'2',
            'waktu_mulai'=>'07:40',
            'waktu_selesai'=>'08:20',
        ]);

        Jam::create([
            'id'=>'3',
            'waktu_mulai'=>'09:00',
            'waktu_selesai'=>'09:40',
        ]);

        // Jam::create([
        //     'id'=>'4',
        //     'waktu_mulai'=>'09:40',
        //     'waktu_selesai'=>'10:20',
        // ]);

        Jam::create([
            'id'=>'4',
            'waktu_mulai'=>'10:00',
            'waktu_selesai'=>'10:40',
        ]);

        Jam::create([
            'id'=>'5',
            'waktu_mulai'=>'10:40',
            'waktu_selesai'=>'11:20',
        ]);

        Jam::create([
            'id'=>'6',
            'waktu_mulai'=>'11:20',
            'waktu_selesai'=>'12:40',
        ]);

        Jam::create([
            'id'=>'7',
            'waktu_mulai'=>'12:40',
            'waktu_selesai'=>'13:20',
        ]);

        Jam::create([
            'id'=>'8',
            'waktu_mulai'=>'13:20',
            'waktu_selesai'=>'14:00',
        ]);

        Jam::create([
            'id'=>'9',
            'waktu_mulai'=>'14:00',
            'waktu_selesai'=>'14:40',
        ]);

        Jam::create([
            'id'=>'10',
            'waktu_mulai'=>'14:40',
            'waktu_selesai'=>'15:20',
        ]);
    }
}
