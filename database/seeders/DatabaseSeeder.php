<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AirtixSeeder::class);

        // Seed an Admin User
        User::firstOrCreate(
            ['email' => 'admin@airtix.com'],
            [
                'name' => 'Admin Airtix',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Seed a Regular User
        User::firstOrCreate(
            ['email' => 'user@airtix.com'],
            [
                'name' => 'User Airtix',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
