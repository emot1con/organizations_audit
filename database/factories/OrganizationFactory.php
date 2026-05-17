<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        $categories = [
            'UKM',
            'BEM',
            'Himpunan',
        ];

        return [

            'name' => ucwords($name),

            'owner_id' => fake()->randomElement([2, 3, 4]),

            'description' => fake()->sentence(),

            'category_organizations' => fake()->randomElement($categories),

            'password_organizations' => Hash::make('organisasi'),

            'organizations_cash' => fake()->numberBetween(
                5000000,
                50000000
            ),

            'contact' => str_replace(' ', '', strtolower($name))
                . '@gmail.com',

        ];
    }
}