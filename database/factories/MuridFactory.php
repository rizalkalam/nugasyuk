<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Murid>
 */
class MuridFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_siswa'=> $this->faker->name(),
            'email'=> $this->faker->email(),
            'password'=> bcrypt('password'),
            'foto_profile'=> 'gambar1.jpg',
            'kelas_id'=> 1,
        ];
    }
}
