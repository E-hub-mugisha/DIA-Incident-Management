<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Finance', 'description' => 'Handles budgeting, audits, and financial planning.'],
            ['name' => 'Operations', 'description' => 'Oversees day-to-day company operations.'],
            ['name' => 'Human Resources', 'description' => 'Manages hiring, benefits, and employee relations.'],
            ['name' => 'ICT', 'description' => 'Responsible for technology and systems.'],
            ['name' => 'Procurement', 'description' => 'Manages purchases and vendor relationships.'],
            ['name' => 'Legal', 'description' => 'Provides legal support and risk compliance.'],
            ['name' => 'Risk Management', 'description' => 'Identifies and mitigates potential business risks.'],
            ['name' => 'Internal Audit', 'description' => 'Performs independent evaluations of systems and controls.'],
            ['name' => 'Customer Service', 'description' => 'Handles customer inquiries and support.'],
            ['name' => 'Public Relations', 'description' => 'Manages external communications and image.'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
