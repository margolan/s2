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

        User::insert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'margulan@0x0.kz',
                    'password' => '$2y$12$IQEpbnZMdBr7ra8oNGMzTu8xCNXG6wybcfnm3yk6K7gp184uHGoPy',
                    'role' => 'admin',
                    'depart' => '',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
                [
                    'name' => 'Sharapat',
                    'email' => 'sharapat@gmail.com',
                    'password' => '$2y$12$sKwHRXEFp7YguWGpKefv4OB6Jif9u6eHQs5HF3xg4F9GOoPc2GZy6',
                    'role' => 'rg',
                    'depart' => 'pos',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
                [
                    'name' => 'Sayasat',
                    'email' => 'sayasat@gmail.com',
                    'password' => '$2y$12$sKwHRXEFp7YguWGpKefv4OB6Jif9u6eHQs5HF3xg4F9GOoPc2GZy6',
                    'role' => 'se',
                    'depart' => 'ter',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
            ]
        );
    }
}
