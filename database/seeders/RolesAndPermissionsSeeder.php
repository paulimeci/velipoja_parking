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
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'user']);

        $permissions = [
            // Admin Module
            ['name' => 'admin.dashboard', 'label' => 'Shikimi i Dashboard-it Admin', 'module' => 'Admin'],
            ['name' => 'admin.konfiguro-oret', 'label' => 'Konfigurimi i Orëve', 'module' => 'Admin'],
            ['name' => 'admin.manage-users', 'label' => 'Menaxhimi i Përdoruesve', 'module' => 'Admin'],
            ['name' => 'admin.delete-users', 'label' => 'Fshirja e Përdoruesve', 'module' => 'Admin'],
            ['name' => 'admin.manage-roles', 'label' => 'Menaxhimi i Roleve & Permissioneve', 'module' => 'Admin'],
            ['name' => 'admin.manage-raportet', 'label' => 'Menaxhimi i Raporteve', 'module' => 'Admin'],

            // Settings Module
            ['name' => 'settings.profile', 'label' => 'Menaxhimi i Profilit', 'module' => 'Settings'],
            ['name' => 'settings.security', 'label' => 'Siguria e Llogarisë', 'module' => 'Settings'],
            ['name' => 'settings.appearance', 'label' => 'Pamja e Sistemit', 'module' => 'Settings'],
            ['name' => 'settings.delete-user', 'label' => 'Fshirja e Përdoruesit', 'module' => 'Settings'],

            // Operatori Module
            ['name' => 'operatori.kryej-operacionet', 'label' => 'Kryerja e Operacioneve', 'module' => 'Operatori'],

            // Existing / Other
            ['name' => 'view reports', 'label' => 'Shikimi i Raporteve', 'module' => 'Reports'],
            ['name' => 'manage users', 'label' => 'Menaxhimi i Përdoruesve', 'module' => 'Admin'],
            ['name' => 'manage all', 'label' => 'Menaxhim i Plotë', 'module' => 'System'],
            ['name' => 'create exercises', 'label' => 'Krijimi i Ushtrimeve', 'module' => 'Exercises'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'label' => $permission['label'],
                    'module' => $permission['module'],
                    'guard_name' => 'web',
                ]
            );
        }

        // Assign all permissions to admin role
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());
    }
}
