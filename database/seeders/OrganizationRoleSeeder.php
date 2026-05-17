<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Organization;
use App\Models\OrganizationRole;
use Illuminate\Database\Seeder;

class OrganizationRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Organization Roles
         */
        $organizationRoles = [
            'Ketua Umum',
            'Bendahara',
            'Sekretaris',
        ];

        /**
         * Division Roles
         */
        $divisionRoles = [
            'Ketua Divisi',
            'Bendahara',
            'Sekretaris',
        ];

        /**
         * All Organizations
         */
        $organizations = Organization::with('divisions')->get();

        foreach ($organizations as $organization) {

            /**
             * Organization Scope Roles
             */
            foreach ($organizationRoles as $role) {

                OrganizationRole::create([

                    'organization_id' => $organization->id,

                    'division_id' => null,

                    'name' => $role,

                    'scope' => 'organization',

                ]);
            }

            /**
             * Division Scope Roles
             */
            foreach ($organization->divisions as $division) {

                foreach ($divisionRoles as $role) {

                    OrganizationRole::create([

                        'organization_id' => $organization->id,

                        'division_id' => $division->id,

                        'name' => $role,

                        'scope' => 'division',

                    ]);
                }
            }
        }
    }
}