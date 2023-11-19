<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{



    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'approve-perencanaan']);
        Permission::create(['name' => 'add-user']);
        Permission::create(['name' => 'create-perencanaan']);
        Permission::create(['name' => 'edit-perencanaan']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo('approve-perencanaan');
        $admin->givePermissionTo('add-user');

        $user = Role::findByName('user');
        $user->givePermissionTo('create-perencanaan');
        $user->givePermissionTo('edit-perencanaan');
    }
}
