<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahmed Fawzy',
            'email' => 'ahmed.fawzy@national-g.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);
    }
}
