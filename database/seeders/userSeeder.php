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
        $admin = User::create([
            'name' => 'Call',
            'email' => 'farizala817@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@sisters.com',
            'phone' => '08888888888',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');
    }
}
