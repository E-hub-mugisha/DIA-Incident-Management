<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = ['Analyst', 'Coordinator', 'Manager', 'Technician', 'Supervisor'];

        // Get all users and departments
        $users = User::all();
        $departments = Department::all();

        // Ensure we have users and departments
        if ($users->isEmpty() || $departments->isEmpty()) {
            $this->command->warn('No users or departments found. Please seed users and departments first.');
            return;
        }

        // Create 10 staff members
        foreach ($users->take(10) as $user) {
            Staff::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => '0788' . rand(100000, 999999),
                'position' => $positions[array_rand($positions)],
                'department_id' => $departments->random()->id,
            ]);
        }
    }
}
