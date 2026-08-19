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
        // Seed default user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'is_admin' => true,
        ]);

        // Seed products, categories, and banners
        $this->call(DummyDataSeeder::class);
    }
}
