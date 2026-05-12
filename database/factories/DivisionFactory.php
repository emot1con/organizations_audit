<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class DivisionFactory extends Factory
{
    protected $model = Division::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => 'Divisi A',
            'category' => 'umum',
            'division_cash' => 100000,
        ];
    }
}