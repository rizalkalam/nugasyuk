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

        Asset::create([
            'id'=>'6',
            'file_asset'=>'assets/asset-6.svg'
        ]);

        Asset::create([
            'id'=>'7',
            'file_asset'=>'assets/asset-7.svg'
        ]);

        Asset::create([
            'id'=>'8',
            'file_asset'=>'assets/asset-8.svg'
        ]);

        Asset::create([
            'id'=>'9',
            'file_asset'=>'assets/asset-9.svg'
        ]);

        Asset::create([
            'id'=>'10',
            'file_asset'=>'assets/asset-10.svg'
        ]);

        Asset::create([
            'id'=>'11',
            'file_asset'=>'assets/asset-11.svg'
        ]);

        Asset::create([
            'id'=>'12',
            'file_asset'=>'assets/asset-12.svg'
        ]);

        Asset::create([
            'id'=>'13',
            'file_asset'=>'assets/asset-13.svg'
        ]);

        Asset::create([
            'id'=>'14',
            'file_asset'=>'assets/asset-14.svg'
        ]);
    }
}
