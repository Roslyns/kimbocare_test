<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve role IDs from the database
        $adminRole = Role::where('name', 'ADMIN')->first();
        $managerRole = Role::where('name', 'MANAER')->first();
        $playerRole = Role::where('name', 'PLAYER')->first();

        // Create one admin user
        $adminUser = User::create([
            'name' => 'Maestros',
            'email' => 'maestros@gmail.com',
            'username' => 'maestros21',
            'password' => Hash::make('PassWord12345'), // Set a password here
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);
        $adminUser->roles()->attach($adminRole->id);

        // Create one manager user
        $managerUser = User::create([
            'name' => 'Tino',
            'email' => 'tino@gmail.com',
            'username' => 'tino',
            'password' => Hash::make('password'), // Set a password here
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);
        $managerUser->roles()->attach($managerRole->id);

        // Create 8 additional users with player roles
        User::factory()->count(8)->create()->each(function ($user) use ($playerRole) {
            $user->roles()->attach($playerRole->id);
        });
    }
}
