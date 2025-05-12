<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membership;
use App\Models\Gym;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'price' => '100',
            'membership_id' => Membership::factory(),
            'gym_id' => Gym::factory(),
            'created_by' => 'seeder',
            'updated_by' => 'seeder',
        ];
    }
}
