<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->firstName() . ' ' . fake()->lastName();

        return [
            'role_id' => 2,

            'name' => $name,

            'email' => Str::lower(
                str_replace(' ', '', $name)
            ) . '@gmail.com',

            'email_verified_at' => now(),

            'password' => Hash::make('admin123'),

            'remember_token' => null,
        ];
    }
}