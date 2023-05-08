<?php

namespace Database\Seeders;

use App\Models\Admin;
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
    }
}
