<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gym = Gym::where('email', 'gym@test.com')->first();

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'gym_id' => $gym->id,
        ]);
        $adminUser->assignRole('gym-admin');

        $instructorUser = User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@test.com',
            'gym_id' => $gym->id,
        ]);
        $instructorUser->assignRole('gym-instructor');
    }
}
