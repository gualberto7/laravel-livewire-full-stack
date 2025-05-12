<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerUser = User::factory()->create([
            'name' => 'Owner User',
            'email' => 'owner@test.com',
        ]);
        $ownerUser->assignRole('gym-owner');

        $ownerUser2 = User::factory()->create([
            'name' => 'Owner User 2',
            'email' => 'owner2@test.com',
        ]);
        $ownerUser2->assignRole('gym-owner');
    }
}
