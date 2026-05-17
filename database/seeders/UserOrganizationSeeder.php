<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Database\Seeder;

class UserOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Ambil semua organization
         */
        $organizations = Organization::with([
            'divisions',
            'roles',
        ])->get();

        /**
         * Semua user random
         * selain admin utama
         */
        $users = User::where('role_id', 2)
            ->get();
            /**
         * Ketua organisasi default
         */
        $organizationOwners = [
            2, // Deru
            3, // Rachel
            4, // Arqan
        ];

        /**
         * ORGANIZATION LEADERS
         */
        foreach ($organizations as $index => $organization) {

            $ownerId = $organizationOwners[$index] ?? 2;

            /**
             * Ketua Umum
             */
            $leaderRole = OrganizationRole::where(
                'organization_id',
                $organization->id
            )
                ->where('scope', 'organization')
                ->where('name', 'Ketua Umum')
                ->first();

            UserOrganization::create([
                'user_id' => $ownerId,
                'organization_id' => $organization->id,
                'role_id' => $leaderRole->id,
                'division_id' => null,
            ]);

            /**
             * Bendahara Organization
             */
            $treasurerRole = OrganizationRole::where(
                'organization_id',
                $organization->id
            )
                ->where('scope', 'organization')
                ->where('name', 'Bendahara')
                ->first();

            UserOrganization::create([
                'user_id' => $users->random()->id,
                'organization_id' => $organization->id,
                'role_id' => $treasurerRole->id,
                'division_id' => null,
            ]);

             /**
             * Sekretaris Organization
             */
            $secretaryRole = OrganizationRole::where(
                'organization_id',
                $organization->id
            )
                ->where('scope', 'organization')
                ->where('name', 'Sekretaris')
                ->first();

            UserOrganization::create([
                'user_id' => $users->random()->id,
                'organization_id' => $organization->id,
                'role_id' => $secretaryRole->id,
                'division_id' => null,
            ]);
        }

         /**
         * DIVISION MEMBERS
         */
        foreach ($organizations as $organization) {

            foreach ($organization->divisions as $division) {

                /**
                 * Ketua Divisi
                 */
                $divisionLeaderRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Ketua Divisi')
                    ->first();

                    UserOrganization::create([
                    'user_id' => $users->random()->id,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionLeaderRole->id,
                    'division_id' => $division->id,
                ]);

                /**
                 * Bendahara Divisi
                 */
                $divisionTreasurerRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                 ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Bendahara')
                    ->first();

                UserOrganization::create([
                    'user_id' => $users->random()->id,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionTreasurerRole->id,
                    'division_id' => $division->id,
                ]);

                 /**
                 * Sekretaris Divisi
                 */
                $divisionSecretaryRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Sekretaris')
                    ->first();

                UserOrganization::create([
                    'user_id' => $users->random()->id,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionSecretaryRole->id,
                    'division_id' => $division->id,
                ]);
            }
        }
    }
}