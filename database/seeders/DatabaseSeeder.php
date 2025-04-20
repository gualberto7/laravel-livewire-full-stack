<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gym;
use App\Models\Membership;
use App\Models\Subscription;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed roles and permissions
        $this->call([
            RolesAndPermissionsSeeder::class
        ]);

        // Create a super admin user
        $ownerUser = User::factory()->create([
            'name' => 'Owner User',
            'email' => 'owner@test.com',
        ]);
        $ownerUser->assignRole('gym-owner');

        // Create a test user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
        ]);
        $adminUser->assignRole('gym-admin');

        $instructorUser = User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@test.com',
        ]);
        $instructorUser->assignRole('gym-instructor');

        $gym = Gym::create([
            'name' => 'Gym 1',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'email' => 'gym@test.com',
            'owner_id' => $ownerUser->id,
        ]);
        $gym2 = Gym::create([
            'name' => 'Gym 2',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'email' => 'gym2@test.com',
            'owner_id' => $ownerUser->id,
        ]);

        $gym->users()->attach($ownerUser, ['role' => 'gym-owner']);
        $gym2->users()->attach($ownerUser, ['role' => 'gym-owner']);

        $gym->users()->attach($adminUser, ['role' => 'gym-admin']);

        $gym->users()->attach($instructorUser, ['role' => 'gym-instructor']);

        $ownerUser2 = User::factory()->create([
            'name' => 'Owner User 2',
            'email' => 'owner2@test.com',
        ]);
        $ownerUser2->assignRole('gym-owner');
        $gym3 = Gym::create([
            'name' => 'Gym 3',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'email' => 'gym3@test.com',
            'owner_id' => $ownerUser2->id,
        ]);

        $gym3->users()->attach($ownerUser2, ['role' => 'gym-owner']);

        $this->call([
            ClientSeeder::class
        ]);

        $membership = Membership::factory()->create([
            'name' => 'Mensual',
            'price' => 200,
            'duration' => 30,
            'description' => 'Membership 1 description',
            'gym_id' => $gym->id,
        ]);

        $clients = Client::take(20)->get();

        foreach ($clients as $client) {
            Subscription::factory()->create([
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'created_by' => 'seeder',
                'updated_by' => 'seeder',
                'client_id' => $client->id,
                'membership_id' => $membership->id,
                'gym_id' => $gym->id,
            ]);
        }
    }
}
