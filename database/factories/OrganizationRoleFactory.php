<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationRole>
 */
class OrganizationRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        /**
         * Random Scope
         */
        $scope = fake()->randomElement([
            'organization',
            'division',
        ]);

        /**
         * Organization Role Names
         */
        $organizationRoles = [
            'Ketua Umum',
            'Bendahara',
            'Sekretaris',
        ];

        /**
         * Division Role Names
         */
        $divisionRoles = [
            'Ketua Divisi',
            'Bendahara',
            'Sekretaris',
        ];

        /**
         * Random Organization
         */
        $organization = Organization::inRandomOrder()->first();

        /**
         * If Division Scope
         */
        if ($scope === 'division') {

            $division = Division::where(
                'organization_id',
                $organization->id
            )->inRandomOrder()->first();

            return [

                'organization_id' => $organization->id,

                'division_id' => $division?->id,

                'name' => fake()->randomElement(
                    $divisionRoles
                ),

                'scope' => 'division',

            ];
        }

        /**
         * Organization Scope
         */
        return [

            'organization_id' => $organization->id,

            'division_id' => null,

            'name' => fake()->randomElement(
                $organizationRoles
            ),

            'scope' => 'organization',

        ];
    }
}