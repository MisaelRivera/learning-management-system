<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'password' => 'password',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'status' => '1'
            ],
            
        );

        User::create(
            [
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'username' => 'instructor',
                'password' => 'password',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'instructor',
                'status' => '1'
            ]
        );

        User::create(
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'username' => 'user',
                'password' => 'password',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'role' => 'user',
                'status' => '1'
            ],
        );
        
    }
}
