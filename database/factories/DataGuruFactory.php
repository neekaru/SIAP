<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataGuru>
 */
class DataGuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('########'),
            'nama' => fake()->name(),
            'no_hp' => fake()->phoneNumber(),
            'user_id' => User::factory(),
            'is_wali' => fake()->boolean(),
        ];
    }
}
