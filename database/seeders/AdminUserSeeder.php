<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Sample Soldier/Staff Users
        $soldiers = [
            ['name' => 'rafi al-mudzaki', 'email' => 'rafi@example.com'],
            ['name' => 'dika nursyamsi', 'email' => 'dika@example.com'],
            ['name' => 'haura nur rizki fadillah', 'email' => 'haura@example.com'],
            ['name' => 'laura nisa intan putri rusmana', 'email' => 'laura@example.com'],
            ['name' => 'Eka Putra', 'email' => 'eka@example.com'],
            ['name' => 'Fajar Pratama', 'email' => 'fajar@example.com'],
            ['name' => 'Gita Sari', 'email' => 'gita@example.com'],
            ['name' => 'Hendra Rahman', 'email' => 'hendra@example.com'],
            ['name' => 'Irwanto Suprapto', 'email' => 'irwanto@example.com'],
            ['name' => 'Joko Sutrisno', 'email' => 'joko@example.com'],
        ];

        foreach ($soldiers as $soldier) {
            User::updateOrCreate(
                ['email' => $soldier['email']],
                [
                    'name' => $soldier['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user', // Role as regular user/soldier
                ]
            );
        }
    }
}
