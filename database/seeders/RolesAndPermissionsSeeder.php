<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Create Roles
         */
        Role::firstOrCreate([
            'name' => 'admin',
        ]);

        Role::firstOrCreate([
            'name' => 'manager',
        ]);

        Role::firstOrCreate([
            'name' => 'user',
        ]);

        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage all']);
        Permission::create(['name' => 'create exercises']);
    }
}
