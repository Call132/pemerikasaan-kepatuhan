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
        Permission::create(['name' => 'lihat-laporan']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user entry']);
        Role::create(['name' => 'user approval']);
        Role::create(['name' => 'Kepala Cabang']);


        $admin = Role::findByName('admin');
        $admin->givePermissionTo('approve-perencanaan');
        $admin->givePermissionTo('add-user');

        $kabag = Role::findByName('user approval');
        $kabag->givePermissionTo('lihat-laporan');
        $kabag->givePermissionTo('approve-perencanaan');


        $entry = Role::findByName('user entry');
        $entry->givePermissionTo('create-perencanaan');
        $entry->givePermissionTo('edit-perencanaan');

        $kacab = Role::findByName('Kepala Cabang');
        $kacab->givePermissionTo('lihat-laporan');
    }
}
