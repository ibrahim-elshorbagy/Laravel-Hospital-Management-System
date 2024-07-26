<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            ['name' => 'manage patients'],
            ['name' => 'manage appointments'],
            ['name' => 'manage doctors'],
            ['name' => 'manage nurses'],
            ['name' => 'manage staff'],
            ['name' => 'manage inventory'],
            ['name' => 'manage billing'],
            ['name' => 'view reports'],
            ['name' => 'schedule an appointment'],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Define roles with permissions
        $roles = [
            'admin' => Permission::all(),
            'doctor' => ['manage patients', 'manage appointments'],
            'patient' => ['schedule an appointment'],
            'receptionist' => ['manage appointments', 'manage billing'],
            // 'nurse' => ['manage patients', 'manage appointments'],
            // 'receptionist' => ['manage appointments', 'manage billing'],
            // 'pharmacist' => ['manage inventory'],
            // 'accountant' => ['view reports', 'manage billing'],
        ];

        // Insert roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }
    }
}
