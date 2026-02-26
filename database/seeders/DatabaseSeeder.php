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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@evoting.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Voter One',
            'email' => 'voter1@test.com',
            'password' => bcrypt('password'),
            'role' => 'voter',
        ]);

        \App\Models\Candidate::create([
            'name' => 'John Doe',
            'party' => 'Green Party',
            'photo_path' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400',
            'description' => 'A visionary leader for a sustainable future.',
        ]);

        \App\Models\Candidate::create([
            'name' => 'Jane Smith',
            'party' => 'Blue Coalition',
            'photo_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400',
            'description' => 'Focused on economic growth and innovation.',
        ]);

        \App\Models\Candidate::create([
            'name' => 'Robert Johnson',
            'party' => 'Red Alliance',
            'photo_path' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400',
            'description' => 'Committed to social justice and equality.',
        ]);
    }
}
