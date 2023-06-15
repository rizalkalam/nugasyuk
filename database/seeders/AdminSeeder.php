<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Asset;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'id'=>'1',
            'nama'=>'Erika Yanti',
            'email'=>'erika@gmail.com',
            'password'=>bcrypt('erika123'),
        ]);

        Asset::create([
            'id'=>'1',
            'file_asset'=>'assets/asset-1.svg'
        ]);

        Asset::create([
            'id'=>'2',
            'file_asset'=>'assets/asset-2.svg'
        ]);

        Asset::create([
            'id'=>'3',
            'file_asset'=>'assets/asset-3.svg'
        ]);

        Asset::create([
            'id'=>'4',
            'file_asset'=>'assets/asset-4.svg'
        ]);

        Asset::create([
            'id'=>'5',
            'file_asset'=>'assets/asset-5.svg'
        ]);
    }
}
