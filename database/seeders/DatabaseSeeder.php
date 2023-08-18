<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory()->create([
            'username' => 'admin',
            'password' => '$2y$10$kej7aWuPtPNdNVc/qpvGTuxHTzD17AIKDvd2XDZraoz9JCgqrUXtu', //qwer1234
        ]);
    }
}
