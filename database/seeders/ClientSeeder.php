<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Gym;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gym = Gym::first();

        Client::factory(50)->create([
            'gym_id' => $gym->id,
        ]);

        Client::factory()->create([
            'name' => 'Gualberto Cuiza',
            'ci' => '7526839',
            'phone' => '78669442',
            'email' => 'gualberto.cuiza@test.com',
            'avatar' => 'https://via.placeholder.com/150',
            'gym_id' => $gym->id,
        ]);
    }
}
