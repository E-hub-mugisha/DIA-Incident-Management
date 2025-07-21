<?php

namespace Database\Seeders;

use App\Models\Mitigation;
use App\Models\Risk;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MitigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $risks = Risk::all();
        $staffMembers = Staff::all();

        if ($risks->isEmpty() || $staffMembers->isEmpty()) {
            $this->command->warn('Please seed the risks and staff tables first.');
            return;
        }

        $strategies = [
            'Implement regular maintenance schedule.',
            'Install backup power system.',
            'Conduct cybersecurity awareness training.',
            'Upgrade outdated pipeline systems.',
            'Improve inventory control process.',
            'Deploy water quality sensors.',
            'Automate billing system checks.',
            'Hire additional technical staff.',
            'Review and revise procurement policy.',
            'Establish emergency response plan.',
        ];

        foreach ($risks->take(10) as $index => $risk) {
            Mitigation::create([
                'risk_id' => $risk->id,
                'strategy' => $strategies[$index % count($strategies)],
                'staff_id' => $staffMembers->random()->id,
                'deadline' => Carbon::now()->addDays(rand(15, 90)),
                'status' => ['Not Started', 'In Progress', 'Completed'][rand(0, 2)],
            ]);
        }
    }
}
