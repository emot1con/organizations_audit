<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserOrganizationFactory extends Factory
{
    protected $model = UserOrganization::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'organization_id' => Organization::factory(),
            'role_id' => OrganizationRole::factory(),
            'division_id' => null,
        ];
    }
}