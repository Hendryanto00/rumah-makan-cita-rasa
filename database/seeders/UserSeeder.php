<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil role
        $adminRole = Role::where('name', 'admin')->first();
        $ownerRole = Role::where('name', 'owner')->first();
        $userRole  = Role::where('name', 'user')->first();

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole?->id,
                'phone' => '081234567890',
                'address' => 'Jl. Raya No. 123, Yogyakarta',
                'email_verified_at' => now(),
            ]
        );

        // Owner
        User::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('password123'),
                'role_id' => $ownerRole?->id,
                'phone' => '081298765432',
                'address' => 'Jl. Malioboro No. 45, Yogyakarta',
                'email_verified_at' => now(),
            ]
        );

        // User Biasa
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password123'),
                'role_id' => $userRole?->id,
                'phone' => '081377788899',
                'address' => 'Jl. Ringroad No. 88, Yogyakarta',
                'email_verified_at' => now(),
            ]
        );
    }
}
