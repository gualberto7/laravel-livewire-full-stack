<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            GymSeeder::class,
            MembershipSeeder::class,
            ClientSeeder::class,
            SubscriptionSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
