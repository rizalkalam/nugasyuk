<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Asset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'file_asset'=>'assets/asset-1.svg',
            'file_vector'=>'assets/vector-1.svg',
            'color'=>'108.08deg, #8287F8 0%, #555AD3 100%'
        ]);

        Asset::create([
            'id'=>'2',
            'file_asset'=>'assets/asset-2.svg',
            'file_vector'=>'assets/vector-2.svg',
            'color'=>'108.08deg, #CD76EA 0%, #8930A7 100%',
        ]);

        Asset::create([
            'id'=>'3',
            'file_asset'=>'assets/asset-3.svg',
            'file_vector'=>'assets/vector-3.svg',
            'color'=>'108.08deg, #86A6C4 0%, #5B8AB6 100%',
        ]);

        Asset::create([
            'id'=>'4',
            'file_asset'=>'assets/asset-4.svg',
            'file_vector'=>'assets/vector-4.svg',
            'color'=>'108.08deg, #30B7AF 0%, #1E9992 99.99%, #30BCB4 100%',
        ]);

        Asset::create([
            'id'=>'5',
            'file_asset'=>'assets/asset-5.svg',
            'file_vector'=>'assets/vector-5.svg',
            'color'=>'108.08deg, #DB63B2 0%, #B93B8F 100%',
        ]);

        Asset::create([
            'id'=>'6',
            'file_asset'=>'assets/asset-6.svg',
            'file_vector'=>'assets/vector-6.svg',
            'color'=>'108.08deg, #8B8ECF 0.01%, #6A6EC7 100%',
        ]);

        Asset::create([
            'id'=>'7',
            'file_asset'=>'assets/asset-7.svg',
            'file_vector'=>'assets/vector-7.svg',
            'color'=>'108.08deg, #F77575 0%, #C04646 100%',
        ]);

        Asset::create([
            'id'=>'8',
            'file_asset'=>'assets/asset-8.svg',
            'file_vector'=>'assets/vector-8.svg',
            'color'=>'108.08deg, #FFAF64 0%, #EB9546 100%'
        ]);

        Asset::create([
            'id'=>'9',
            'file_asset'=>'assets/asset-9.svg',
            'file_vector'=>'assets/vector-9.svg',
            'color'=>'108.08deg, #FFEC3D 0%, #F0C93A 100%'
        ]);

        Asset::create([
            'id'=>'10',
            'file_asset'=>'assets/asset-10.svg',
            'file_vector'=>'assets/vector-10.svg',
            'color'=>'108.08deg, #40E45E 0%, #28C044 100%'
        ]);

        Asset::create([
            'id'=>'11',
            'file_asset'=>'assets/asset-11.svg',
            'file_vector'=>'assets/vector-11.svg',
            'color'=>'108.08deg, #3DA2B9 0%, #2A8AA0 100%'
        ]);

        Asset::create([
            'id'=>'12',
            'file_asset'=>'assets/asset-12.svg',
            'file_vector'=>'assets/vector-12.svg',
            'color'=>'108.08deg, #ED7BA4 0%, #D7487B 100%'
        ]);

        Asset::create([
            'id'=>'13',
            'file_asset'=>'assets/asset-13.svg',
            'file_vector'=>'assets/vector-13.svg',
            'color'=>'108.08deg, #E6A0FF 0%, #DB76FF 100%'
        ]);

        Asset::create([
            'id'=>'14',
            'file_asset'=>'assets/asset-14.svg',
            'file_vector'=>'assets/vector-14.svg',
            'color'=>'108.08deg, #FFC194 0%, #FFA25E 100%'
        ]);

        Asset::create([
            'id'=>'15',
            'file_asset'=>'assets/asset-15.svg',
            'file_vector'=>'assets/vector-15.svg',
            'color'=>'108.08deg, #C963F9 0%, #6526A4 100%'
        ]);

        DB::table('jobs')->delete();
        DB::table('failed_jobs')->delete();
    }
}
