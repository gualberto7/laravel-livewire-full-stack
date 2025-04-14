<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gym;
use App\Models\Membership;

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
            RolesAndPermissionsSeeder::class,
            ClientSeeder::class,
        ]);

        // Create a super admin user
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
        ]);
        $superAdmin->assignRole('super-admin');

        // Create a test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0987654321',
        ]);

        $gym = Gym::create([
            'name' => 'Gym 1',
            'address' => '123 Main St',
            'phone' => '1234567890',
            'email' => 'gym@example.com',
            'owner_id' => $superAdmin->id,
        ]);

        $gym->users()->attach($superAdmin, ['role' => 'super-admin']);

        $gym->users()->attach($testUser, ['role' => 'admin']);
        
        Membership::factory()->create([
            'name' => 'Mensual',
            'price' => 200,
            'duration' => 30,
            'description' => 'Membership 1 description',
            'gym_id' => $gym->id,
        ]);
        
    }
}
