<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'John Doe', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin'],
            ['name' => 'Jane Doe', 'email' => 'user@example.com', 'password' => bcrypt('password'), 'role' => 'user'],
        ];

        DB::table('users')->insert($users);
    }
}
