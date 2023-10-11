<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BadanUsaha;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
        User::factory()->create([
            'name' => 'Call',
            'email' => 'admin@sisters.com',
            'phone' => '1234567890', // Ganti dengan nomor telepon yang sesuai
            'password' => bcrypt('12345678'), // Ganti dengan email admin yang sesuai
        ])->assignRole($adminRole);
        //BadanUsaha::factory(15)->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
