<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Client;
use App\Models\Membership;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gym = Gym::where('email', 'gym@test.com')->first();
        $membership = Membership::where('gym_id', $gym->id)->first();
        $clients = Client::where('gym_id', $gym->id)->take(20)->get();
        foreach ($clients as $client) {
            $subscription = Subscription::factory()->create([
                'membership_id' => $membership->id,
                'gym_id' => $gym->id
            ]);
            $subscription->clients()->attach($client);
        }
    }
}
