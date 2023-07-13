<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\JamSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\GuruSeeder;
use Database\Seeders\KodeSeeder;
use Database\Seeders\OrtuSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SoalSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\KelasSeeder;
use Database\Seeders\MapelSeeder;
use Database\Seeders\MuridSeeder;
use Database\Seeders\TugasSeeder;
use Database\Seeders\JadwalSeeder;
use Database\Seeders\MateriSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\JurusanSeeder;
use Database\Seeders\TingkatanSeeder;
use Database\Seeders\PercakapanSeeder;
use Database\Seeders\PengumpulanSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            GuruSeeder::class,
            MuridSeeder::class,
            OrtuSeeder::class,
            KelasSeeder::class,
            JurusanSeeder::class,
            TingkatanSeeder::class,
            KodeSeeder::class,
            MapelSeeder::class,
            TugasSeeder::class,
            MateriSeeder::class,
            PengumpulanSeeder::class,
            AdminSeeder::class,
            JamSeeder::class,
            HariSeeder::class,
            JadwalSeeder::class,
            PercakapanSeeder::class,
            // SoalSeeder::class
            // StatusSeeder::class
         ]);
    }
}
