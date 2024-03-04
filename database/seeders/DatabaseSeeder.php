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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Ahmed Abdelraouf',
            'email' => 'ahmedraoouf123@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        \App\Models\UserAuthentication::factory()->create([
            'user_id' => 1,
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);
    }
}
