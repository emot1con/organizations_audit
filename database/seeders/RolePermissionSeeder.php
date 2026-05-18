<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\OrganizationRole;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = OrganizationRole::all();

        foreach ($roles as $role) {

            /**
             * Ambil permission sesuai scope role
             */
            $permissions = Permission::where(
                'scope',
                $role->scope
            )->get();

            /**
             * Anggota
             * cuma permission transaksi
             */
            if (
                strtolower($role->name) === 'anggota'
            ) {

                $readPermission = $permissions
                    ->where('name', 'transaksi')
                    ->pluck('id');

                $role->permissions()->sync(
                    $readPermission
                );

                continue;
            }

            /**
             * Selain anggota
             * dapat semua permission
             */
            $role->permissions()->sync(
                $permissions->pluck('id')
            );
        }
    }
}