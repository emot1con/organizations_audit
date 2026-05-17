<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $divisionNames = [
            'Media Kreatif',
            'Acara Inti',
            'Keamanan Event',
            'Humas Digital',
            'Kaderisasi',
            'Kominfo',
            'Design Visual',
            'Dana Usaha',
            'Pengembangan SDM',
            'Dokumentasi',
            'Perlengkapan',
            'Creative Team',
            'Sponsorship',
            'Operasional',
            'Public Relation',
        ];

        return [

            /**
             * Random Organization
             */
            'organization_id' => Organization::inRandomOrder()->first()->id,

            /**
             * Random Division Name
             */
            'name' => fake()->randomElement($divisionNames),

            /**
             * tetap | sementara
             */
            'category' => fake()->randomElement([
                'tetap',
                'sementara',
            ]),

            /**
             * Division Cash
             */
            'division_cash' => fake()->numberBetween(
                200000,
                5000000
            ),

        ];
    }
}