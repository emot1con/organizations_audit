<?php

namespace Database\Seeders;

use App\Models\User;
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
         * Semua organization
         */
        $organizations = Organization::with([
            'divisions',
            'roles',
        ])->get();

        /**
         * Semua user biasa
         */
        $users = User::where(
            'role_id',
            2
        )->get();

        /**
         * Owner default organization
         */
        $organizationOwners = [
            2, // Deru
            3, // Rachel
            4, // Arqan
        ];

        /**
         * =========================================
         * ORGANIZATION MAIN MEMBERS
         * =========================================
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
         * =========================================
         * DIVISION MEMBERS
         * =========================================
         */
        foreach ($organizations as $organization) {

            /**
             * Role anggota utama organization
             */
            $memberRole = OrganizationRole::where(
                'organization_id',
                $organization->id
            )
                ->where('scope', 'organization')
                ->where('name', 'Anggota')
                ->first();

            foreach ($organization->divisions as $division) {

                /**
                 * User yang sudah dipakai di division ini
                 */
                $usedUserIds = UserOrganization::where(
                    'organization_id',
                    $organization->id
                )
                    ->where(
                        'division_id',
                        $division->id
                    )
                    ->pluck('user_id');

                /**
                 * =========================================
                 * Ketua Divisi
                 * =========================================
                 */
                $divisionLeaderRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Ketua Divisi')
                    ->first();

                $leaderUserId = $users
                    ->whereNotIn('id', $usedUserIds)
                    ->random()
                    ->id;

                $usedUserIds->push($leaderUserId);

                /**
                 * Tambahkan role utama organization
                 */
                $exists = UserOrganization::where(
                    'user_id',
                    $leaderUserId
                )
                    ->where(
                        'organization_id',
                        $organization->id
                    )
                    ->whereNull('division_id')
                    ->exists();

                if (!$exists) {

                    UserOrganization::create([
                        'user_id' => $leaderUserId,
                        'organization_id' => $organization->id,
                        'role_id' => $memberRole->id,
                        'division_id' => null,
                    ]);
                }

                /**
                 * Role division
                 */
                UserOrganization::create([
                    'user_id' => $leaderUserId,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionLeaderRole->id,
                    'division_id' => $division->id,
                ]);

                /**
                 * =========================================
                 * Bendahara Divisi
                 * =========================================
                 */
                $divisionTreasurerRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Bendahara')
                    ->first();

                $treasurerUserId = $users
                    ->whereNotIn('id', $usedUserIds)
                    ->random()
                    ->id;

                $usedUserIds->push($treasurerUserId);

                $exists = UserOrganization::where(
                    'user_id',
                    $treasurerUserId
                )
                    ->where(
                        'organization_id',
                        $organization->id
                    )
                    ->whereNull('division_id')
                    ->exists();

                if (!$exists) {

                    UserOrganization::create([
                        'user_id' => $treasurerUserId,
                        'organization_id' => $organization->id,
                        'role_id' => $memberRole->id,
                        'division_id' => null,
                    ]);
                }

                UserOrganization::create([
                    'user_id' => $treasurerUserId,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionTreasurerRole->id,
                    'division_id' => $division->id,
                ]);

                /**
                 * =========================================
                 * Sekretaris Divisi
                 * =========================================
                 */
                $divisionSecretaryRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Sekretaris')
                    ->first();

                $secretaryUserId = $users
                    ->whereNotIn('id', $usedUserIds)
                    ->random()
                    ->id;

                $usedUserIds->push($secretaryUserId);

                $exists = UserOrganization::where(
                    'user_id',
                    $secretaryUserId
                )
                    ->where(
                        'organization_id',
                        $organization->id
                    )
                    ->whereNull('division_id')
                    ->exists();

                if (!$exists) {

                    UserOrganization::create([
                        'user_id' => $secretaryUserId,
                        'organization_id' => $organization->id,
                        'role_id' => $memberRole->id,
                        'division_id' => null,
                    ]);
                }

                UserOrganization::create([
                    'user_id' => $secretaryUserId,
                    'organization_id' => $organization->id,
                    'role_id' => $divisionSecretaryRole->id,
                    'division_id' => $division->id,
                ]);
            }
        }
    }
}