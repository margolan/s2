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
            'name' => 'Admin',
            'email' => 'margulan@0x0.kz',
            'password' => '$2y$12$IQEpbnZMdBr7ra8oNGMzTu8xCNXG6wybcfnm3yk6K7gp184uHGoPy'
        ]);
    }
}
