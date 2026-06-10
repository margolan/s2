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
                    'name' => 'pos',
                    'email' => 'pos@0x0.kz',
                    'password' => '$2y$12$sKwHRXEFp7YguWGpKefv4OB6Jif9u6eHQs5HF3xg4F9GOoPc2GZy6',
                    'role' => 'rg',
                    'depart' => 'pos',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
                [
                    'name' => 'ter',
                    'email' => 'ter@0x0.kz',
                    'password' => '$2y$12$VN5jnyOWZphzxInfWUog2u6PPDO/QDtRDPQHTOUCtOC3inMCTVPcu',
                    'role' => 'se',
                    'depart' => 'ter',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
                [
                    'name' => 'ter1',
                    'email' => 'ter1@0x0.kz',
                    'password' => '$2y$12$sWesmOPpy7qM/5pJzmk9TeEKfiqAx1PI9pL2fGdzglLLinYxJ7WjK',
                    'role' => 'se',
                    'depart' => 'ter',
                    'city' => 'aktobe',
                    'active' => '1',
                ],
            ]
        );
    }
}
