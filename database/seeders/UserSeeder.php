<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@library.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'membership_id' => 'LIB20240001',
        ]);

        // Create librarian user
        User::create([
            'name' => 'Head Librarian',
            'email' => 'librarian@library.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
            'status' => 'active',
            'membership_id' => 'LIB20240002',
        ]);

        // Create sample members
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Member {$i}",
                'email' => "member{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
                'membership_id' => 'LIB2024' . str_pad($i + 2, 4, '0', STR_PAD_LEFT),
                'membership_expiry' => now()->addYear(),
            ]);
        }
    }
}