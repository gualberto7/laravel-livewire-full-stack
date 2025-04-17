<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for gym management
        $gymPermissions = [
            'manage gym',
            'manage gym staff',
            'manage gym settings',
            'manage gym reports',
            'manage gym memberships',
            'manage gym subscriptions',
        ];

        foreach ($gymPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin role
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Gym Owner role
        $gymOwnerRole = Role::create(['name' => 'gym-owner']);
        $gymOwnerRole->givePermissionTo([
            'manage gym',
            'manage gym staff',
            'manage gym settings',
            'manage gym reports',
            'manage gym memberships',
            'manage gym subscriptions',
        ]);

        // Gym Admin role
        $gymAdminRole = Role::create(['name' => 'gym-admin']);
        $gymAdminRole->givePermissionTo([
            'manage gym',
            'manage gym memberships',
            'manage gym subscriptions',
        ]);

        // Gym Instructor role
        $gymInstructorRole = Role::create(['name' => 'gym-instructor']);
        $gymInstructorRole->givePermissionTo([
            'manage gym',
            'manage gym memberships',
            'manage gym subscriptions',
        ]);
    }
}
