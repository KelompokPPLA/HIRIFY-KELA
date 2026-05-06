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
        // Admin account
        User::firstOrCreate(
            ['email' => 'admin@hirify.test'],
            [
                'name' => 'Admin Hirify',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // Default jobseeker for testing
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'),
                'role' => 'jobseeker',
            ]
        );

        $this->call([
            MentorshipDemoSeeder::class,
            SkillTrainingSeeder::class,
        ]);
    }
}
