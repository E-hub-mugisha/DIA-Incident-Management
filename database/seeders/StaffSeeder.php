<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Military Intelligence Directorate', 'description' => 'MID'],
            ['name' => 'Rwanda Air Force', 'description' => 'RAF'],
            ['name' => 'Rwanda Navy Division', 'description' => 'RND'],
            ['name' => 'Logistics and Support Command', 'description' => 'LSC'],
            ['name' => 'Cyber Defense Unit', 'description' => 'CDU'],
            ['name' => 'Peacekeeping Operations', 'description' => 'PKO'],
            ['name' => 'Special Forces Command', 'description' => 'SFC'],
            ['name' => 'Military Police', 'description' => 'MP'],
            ['name' => 'Medical Corps', 'description' => 'MC'],
            ['name' => 'Defense Communications', 'description' => 'DCOM'],
        ];

        // Create or update departments
        foreach ($departments as $deptData) {
            Department::updateOrCreate(
                ['name' => $deptData['name']],
                ['description' => $deptData['description']]
            );
        }

        // Generate 5 staff members per department
        foreach ($departments as $dept) {
            $department = Department::where('name', $dept['name'])->first();

            for ($i = 1; $i <= 5; $i++) {
                $staffName = $this->generateRandomName($dept['name'], $i);
                $email = $this->generateEmail($staffName);

                // Create or update user
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $staffName,
                        'password' => Hash::make('password123'), // default password, change for production
                        'role' => 'handler',
                    ]
                );

                // Create or update staff
                Staff::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name' => $staffName,
                        'email' => $email,
                        'phone' => '0788' . rand(100000, 999999), // random phone number
                        'position' => 'Staff Member',
                        'department_id' => $department->id,
                    ]
                );
            }
        }
    }

    // Generate fake Rwandan style names based on department + index
    private function generateRandomName($departmentName, $index)
    {
        $firstNames = ['Jean', 'Alice', 'Patrick', 'Claire', 'Emmanuel', 'Esther', 'Joseph', 'Marie', 'Paul', 'Rose'];
        $lastNames = ['Mukasa', 'Uwimana', 'Nkurunziza', 'Munyaneza', 'Kamanzi', 'Hakizimana', 'Niyonzima', 'Munyakazi'];

        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];

        return ucfirst($firstName) . ' ' . ucfirst($lastName);
    }

    // Generate email from name (lowercase, no spaces)
    private function generateEmail($name)
    {
        $baseEmail = strtolower(str_replace(' ', '.', $name));
        return $baseEmail . '@defense.rw';
    }
}
