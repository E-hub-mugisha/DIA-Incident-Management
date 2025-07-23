<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cybersecurity Breach',
                'description' => 'Incidents involving unauthorized access, data leaks, or malware attacks.'
            ],
            [
                'name' => 'Border Violation',
                'description' => 'Reports of unauthorized border crossings or foreign intrusions.'
            ],
            [
                'name' => 'Internal Threat',
                'description' => 'Threats originating from within the armed forces or allied agencies.'
            ],
            [
                'name' => 'Public Disturbance',
                'description' => 'Protests, riots, or civil unrest affecting national security.'
            ],
            [
                'name' => 'Weapons Malfunction',
                'description' => 'Defective or malfunctioning military equipment during operations or training.'
            ],
            [
                'name' => 'Espionage Suspected',
                'description' => 'Suspicious activity potentially linked to spying or information leaks.'
            ],
            [
                'name' => 'Unidentified Aerial Activity',
                'description' => 'Sightings or detections of unknown aircraft or drones in restricted airspace.'
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
