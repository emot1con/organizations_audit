<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Default Users
         */

        User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'role_id' => 1,
            'name' => 'Admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => null,
        ]);

        User::firstOrCreate([
            'email' => 'deru@gmail.com',
        ], [
            'role_id' => 2,
            'name' => 'Deru',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => null,
        ]);

        User::firstOrCreate([
            'email' => 'rachel@gmail.com',
        ], [
            'role_id' => 2,
            'name' => 'Rachel',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => null,
        ]);

        User::firstOrCreate([
            'email' => 'arqan@gmail.com',
        ], [
            'role_id' => 2,
            'name' => 'Arqan',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => null,
        ]);

        /**
         * Random Users
         */

        // User::factory()
        //     ->count(100)
        //     ->create();
    }
}