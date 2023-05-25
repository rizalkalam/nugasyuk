<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_guru'=> $this->faker->name(),
            'email'=> $this->faker->email(),
            'password'=> bcrypt('password'),
            'niy'=>'0123',
            'foto_profile'=>'gambar1.jpg',
            'mapel_id'=>1
        ];
    }
}
