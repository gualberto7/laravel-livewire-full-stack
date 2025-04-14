<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
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
            'price' => fake()->randomFloat(2, 10, 100),
            'duration' => fake()->numberBetween(1, 30),
            'description' => fake()->sentence(),
            'created_by' => 'seeder',
            'updated_by' => 'seeder',
            'gym_id' => 1,
        ];
    }
}
