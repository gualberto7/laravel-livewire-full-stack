<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'ci' => fake()->unique()->randomNumber(8),
            'phone' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->email(),
            'avatar' => fake()->imageUrl(),
        ];
    }
}
