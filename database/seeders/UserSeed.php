<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commonPassword = Hash::make('leapp132');

        $users = [
            ['name' => 'Lucas', 'email' => 'lucasoaresnet@gmail.com', 'role' => 'super-admin'],
            ['name' => 'Leticia', 'email' => 'leticia2013rclele@gmail.com', 'role' => 'super-admin']
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $commonPassword
            ])->assignRole($userData['role']);
        }

    }
}
