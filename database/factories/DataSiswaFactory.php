<?php

namespace Database\Factories;

use App\Models\DataKelas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataSiswa>
 */
class DataSiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'user_id' => User::factory(),
            'nis' => fake()->unique()->numerify('########'),
            'no_hp_ortu' => fake()->phoneNumber(),
            'kelas_id' => DataKelas::inRandomOrder()->first()?->id,
        ];
    }
}
