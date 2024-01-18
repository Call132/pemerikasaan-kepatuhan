<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Call',
            'email' => 'farizala817@gmail.com',
            'role' => 'User Entry',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'name' => 'User Approval',
            'email' => 'user@approval.com',
            'role' => 'User Approval',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'name' => 'Kepala Cabang',
            'email' => 'KepalaCabang@gmail.com',
            'role' => 'Kepala Cabang',
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@sisters.com',
            'role' => 'Admin',
            'password' => bcrypt('admin123'),
        ]);
    }
}
