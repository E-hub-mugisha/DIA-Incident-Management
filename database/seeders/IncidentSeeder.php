<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all category and user IDs for foreign keys
        $categoryIds = Category::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        // Sample incident titles and descriptions (Rwanda-related defense context)
        $sampleIncidents = [
            [
                'title' => 'Unauthorized Access Detected',
                'description' => 'Suspicious access attempt reported in Military Intelligence Directorate servers.',
                'location' => 'Kigali HQ',
                'severity' => 'high',
            ],
            [
                'title' => 'Communication Equipment Failure',
                'description' => 'Failure detected in Defense Communications network during field operation.',
                'location' => 'Nyamirambo Base',
                'severity' => 'medium',
            ],
            [
                'title' => 'Vehicle Accident During Patrol',
                'description' => 'Rwanda Air Force vehicle overturned during routine patrol in Northern Province.',
                'location' => 'Musanze',
                'severity' => 'critical',
            ],
            [
                'title' => 'Data Breach Attempt',
                'description' => 'Attempted cyber intrusion detected on Cyber Defense Unit’s systems.',
                'location' => 'Kigali Cyber Defense Center',
                'severity' => 'critical',
            ],
            [
                'title' => 'Medical Emergency at Base',
                'description' => 'A staff member suffered injury during training exercise.',
                'location' => 'Gako Military Training Camp',
                'severity' => 'low',
            ],
        ];

        foreach ($sampleIncidents as $data) {
            Incident::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'severity' => $data['severity'],
                'status' => 'new',
                'location' => $data['location'],
                'reported_by' => $userIds[array_rand($userIds)],
                // 50% chance to have an assigned user
                'assigned_to' => rand(0,1) ? $userIds[array_rand($userIds)] : null,
            ]);
        }
    }
}
