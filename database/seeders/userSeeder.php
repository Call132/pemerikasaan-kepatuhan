<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        $user = User::create([
            'name' => 'farizal',
            'email' => 'frzlhmd@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('user');
    }
}
