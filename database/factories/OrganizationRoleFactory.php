<?php

namespace Database\Factories;

use App\Models\OrganizationRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationRoleFactory extends Factory
{
    protected $model = OrganizationRole::class;

    public function definition(): array
    {
        return [
            'name' => 'admin',
            'scope' => 'organization',
        ];
    }
}