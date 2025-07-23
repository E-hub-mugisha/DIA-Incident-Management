<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
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

        foreach ($departments as $dept) {
            DB::table('departments')->updateOrInsert(
                ['description' => $dept['description']],
                [
                    'name' => $dept['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
