<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Gym;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionHistory>
 */
class SubscriptionHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'membership' => $this->faker->word(),
            'duration' => $this->faker->numberBetween(1, 365),
            'price' => $this->faker->numberBetween(100, 1000),
            'client_id' => Client::factory(),
            'gym_id' => Gym::factory(),
        ];
    }
}
