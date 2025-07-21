<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'Risk Manager', 'Department Head', 'Staff', 'Auditor'];

        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'), // default password
                'role' => $roles[array_rand($roles)],
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
