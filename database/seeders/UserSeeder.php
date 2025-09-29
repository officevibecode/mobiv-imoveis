<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'MOBIV Admin',
            'email' => 'office@vibecode.pt',
            'password' => bcrypt('M0biv#2025!'),
            'role' => \App\Enums\UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);
    }
}
