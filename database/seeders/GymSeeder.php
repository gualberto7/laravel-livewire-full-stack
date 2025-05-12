<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerUser = User::where('email', 'owner@test.com')->first();
        Gym::factory()->create([
            'name' => 'Gym 1',
            'email' => 'gym@test.com',
            'owner_id' => $ownerUser->id,
        ]);
        Gym::factory()->create([
            'name' => 'Gym 2',
            'email' => 'gym2@test.com',
            'owner_id' => $ownerUser->id,
        ]);
        
        $ownerUser2 = User::where('email', 'owner2@test.com')->first();
        Gym::factory()->create([
            'name' => 'Gym 3',
            'email' => 'gym3@test.com',
            'owner_id' => $ownerUser2->id,
        ]);
    }
}
