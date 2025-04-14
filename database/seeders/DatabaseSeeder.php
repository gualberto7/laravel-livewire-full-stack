<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
    }
}
