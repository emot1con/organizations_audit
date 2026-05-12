<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    private static $roles = [
        'superadmin',
        'user',
        'admin',
    ];

    private static $index = 0;

    public function definition(): array
    {
        return [
            'name' => self::$roles[self::$index++ % count(self::$roles)],
        ];
    }
}