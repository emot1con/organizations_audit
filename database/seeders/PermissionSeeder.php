<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            /**
             * Organization Permissions
             */
            [
                'name' => 'transaksi',
                'scope' => 'organization',
            ],

            [
                'name' => 'divisi',
                'scope' => 'organization',
            ],

            [
                'name' => 'role',
                'scope' => 'organization',
            ],

            [
                'name' => 'organisasi',
                'scope' => 'organization',
            ],

            /**
             * Division Permissions
             */
            [
                'name' => 'transaksi',
                'scope' => 'division',
            ],

            [
                'name' => 'role',
                'scope' => 'division',
            ],

            [
                'name' => 'divisi',
                'scope' => 'division',
            ],

        ];

        foreach ($permissions as $permission) {

            Permission::create($permission);

        }
    }
}