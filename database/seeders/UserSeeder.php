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
        // Admins
        User::create([
            'name' => 'Major General Jean Bosco',
            'email' => 'jean.bosco@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Brigadier General Innocent Nduwayezu',
            'email' => 'innocent.nduwayezu@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Handlers
        User::create([
            'name' => 'Captain Emmanuel Nkurunziza',
            'email' => 'emmanuel.nkurunziza@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'handler',
        ]);

        User::create([
            'name' => 'Lieutenant Alice Umutoni',
            'email' => 'alice.umutoni@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'handler',
        ]);

        // Reporters
        User::create([
            'name' => 'Private Eric Mugisha',
            'email' => 'eric.mugisha@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'reporter',
        ]);

        User::create([
            'name' => 'Sergeant Diane Uwase',
            'email' => 'diane.uwase@rdf.gov.rw',
            'password' => Hash::make('password'),
            'role' => 'reporter',
        ]);
    }
}
