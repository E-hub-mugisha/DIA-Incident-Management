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
            ['name' => 'Financial', 'description' => 'Risks related to financial activities.'],
            ['name' => 'Operational', 'description' => 'Risks arising from operations and logistics.'],
            ['name' => 'Compliance', 'description' => 'Risks related to laws, regulations, and policies.'],
            ['name' => 'Strategic', 'description' => 'Risks that affect business direction or goals.'],
            ['name' => 'IT & Cybersecurity', 'description' => 'Technology-related threats including breaches and outages.'],
            ['name' => 'Reputation', 'description' => 'Risks impacting company image or stakeholder trust.'],
            ['name' => 'Health & Safety', 'description' => 'Employee and environmental safety concerns.'],
            ['name' => 'Project', 'description' => 'Risks associated with ongoing or upcoming projects.'],
            ['name' => 'Environmental', 'description' => 'Risks involving natural disasters or environmental issues.'],
            ['name' => 'Legal', 'description' => 'Litigation or legal non-compliance risks.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
