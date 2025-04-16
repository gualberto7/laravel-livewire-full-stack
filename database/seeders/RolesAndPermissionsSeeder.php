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
            'view gym',
            'create gym',
            'edit gym',
            'delete gym',
            'manage gym staff',
            'view gym staff',
            'add gym staff',
            'remove gym staff',
            'edit gym staff',
            'manage gym settings',
            'view gym reports',
            'manage gym memberships',
            'view gym memberships',
            'add gym memberships',
            'remove gym memberships',
            'edit gym memberships',
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
            'view gym',
            'edit gym',
            'manage gym staff',
            'view gym staff',
            'add gym staff',
            'remove gym staff',
            'edit gym staff',
            'manage gym settings',
            'view gym reports',
            'manage gym memberships',
            'view gym memberships',
            'add gym memberships',
            'remove gym memberships',
            'edit gym memberships',
        ]);

        // Gym Admin role
        $gymAdminRole = Role::create(['name' => 'gym-admin']);
        $gymAdminRole->givePermissionTo([
            'view gym',
            'manage gym staff',
            'view gym staff',
            'add gym staff',
            'remove gym staff',
            'edit gym staff',
            'manage gym settings',
            'view gym reports',
            'manage gym memberships',
            'view gym memberships',
            'add gym memberships',
            'remove gym memberships',
            'edit gym memberships',
        ]);

        // Gym Instructor role
        $gymInstructorRole = Role::create(['name' => 'gym-instructor']);
        $gymInstructorRole->givePermissionTo([
            'view gym',
            'view gym staff',
            'view gym memberships',
            'add gym memberships',
            'remove gym memberships',
            'edit gym memberships',
        ]);

        // Gym Staff role (basic staff with minimal permissions)
        $gymStaffRole = Role::create(['name' => 'gym-staff']);
        $gymStaffRole->givePermissionTo([
            'view gym',
            'view gym staff',
            'view gym memberships',
        ]);
    }
}
