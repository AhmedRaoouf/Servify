<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user record
        $user_id = DB::table('users')->insertGetId([
            'name' => "ahmed raouf",
            'email' => 'ahmedraoouf123@gmail.com',
            'password' => Hash::make('123456789'),
            'role_id' => 1,
        ]);

        // Insert into users_authentications table with the obtained user_id
        DB::table('user_authentications')->insert([
            'user_id' => $user_id,
        ]);
    }
}
