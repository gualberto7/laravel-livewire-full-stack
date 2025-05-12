<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Gym;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckIn>
 */
class CheckInFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'gym_id' => Gym::factory(),
            'created_by' => 'seeder',
            'updated_by' => 'seeder',
        ];
    }
}
