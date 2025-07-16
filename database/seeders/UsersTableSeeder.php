<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'name' => 'User ' . ($i + 1),
                'username' => 'user' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@example.com',
                'password' => Hash::make('password'), // You can change 'password' with any password you want
            ]);
        }
    }
}
