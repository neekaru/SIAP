<?php

namespace Database\Factories;

use App\Models\DataGuru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataKelas>
 */
class DataKelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('##??'),
            'nama' => fake()->word(),
            'walikelas_id' => DataGuru::factory(),
        ];
    }
}
