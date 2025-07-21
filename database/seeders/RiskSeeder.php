<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;
use App\Models\Department;
use App\Models\Category;

class RiskSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        $categories = Category::all();

        if ($departments->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Please seed departments and categories first.');
            return;
        }

        $risks = [
            [
                'title' => 'Water Supply Interruption',
                'description' => 'Disruption in water supply due to equipment failure or natural disaster.',
                'likelihood' => 'High',
                'impact' => 'High',
                'status' => 'Pending',
            ],
            [
                'title' => 'Cybersecurity Breach',
                'description' => 'Potential data breach in customer billing system.',
                'likelihood' => 'Medium',
                'impact' => 'High',
                'status' => 'In Progress',
            ],
            [
                'title' => 'Pipeline Contamination',
                'description' => 'Contamination of water due to pipeline corrosion or external pollutants.',
                'likelihood' => 'High',
                'impact' => 'High',
                'status' => 'Escalated',
            ],
            [
                'title' => 'Delayed Procurement Process',
                'description' => 'Delays in acquiring necessary treatment chemicals due to poor planning.',
                'likelihood' => 'Medium',
                'impact' => 'Medium',
                'status' => 'Pending',
            ],
            [
                'title' => 'Lack of Skilled Staff',
                'description' => 'Shortage of skilled maintenance engineers affecting service delivery.',
                'likelihood' => 'High',
                'impact' => 'Medium',
                'status' => 'Mitigated',
            ],
            [
                'title' => 'Flooding at Pumping Station',
                'description' => 'Unexpected flooding could damage equipment and halt operations.',
                'likelihood' => 'Low',
                'impact' => 'High',
                'status' => 'Pending',
            ],
            [
                'title' => 'Regulatory Non-Compliance',
                'description' => 'Failure to comply with water quality regulations can result in legal penalties.',
                'likelihood' => 'Medium',
                'impact' => 'High',
                'status' => 'Pending',
            ],
            [
                'title' => 'Fuel Shortage',
                'description' => 'Shortage of fuel may stop generator backup systems.',
                'likelihood' => 'Medium',
                'impact' => 'Medium',
                'status' => 'In Progress',
            ],
            [
                'title' => 'Community Protests',
                'description' => 'Service interruptions may lead to community dissatisfaction and protests.',
                'likelihood' => 'High',
                'impact' => 'Medium',
                'status' => 'Escalated',
            ],
            [
                'title' => 'Internal Fraud',
                'description' => 'Risk of financial fraud within procurement or billing units.',
                'likelihood' => 'Low',
                'impact' => 'High',
                'status' => 'Pending',
            ],
        ];

        foreach ($risks as $risk) {
            Risk::create([
                'title' => $risk['title'],
                'description' => $risk['description'],
                'department_id' => $departments->random()->id,
                'category_id' => $categories->random()->id,
                'likelihood' => $risk['likelihood'],
                'impact' => $risk['impact'],
                'level' => $this->calculateLevel($risk['likelihood'], $risk['impact']),
                'status' => $risk['status'],
            ]);
        }
    }

    private function calculateLevel(string $likelihood, string $impact): string
    {
        $scale = [
            'Low' => 1,
            'Medium' => 2,
            'High' => 3,
        ];

        $score = $scale[$likelihood] * $scale[$impact];

        if ($score <= 2) return 'Low';
        elseif ($score <= 4) return 'Medium';
        elseif ($score <= 6) return 'High';
        else return 'Critical';
    }
}
