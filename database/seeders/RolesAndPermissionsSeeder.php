<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $createPostPermission = Permission::create(['name' => 'create post']);
        $approvePostPermission = Permission::create(['name' => 'approve post']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($createPostPermission, $approvePostPermission);
    }
}
