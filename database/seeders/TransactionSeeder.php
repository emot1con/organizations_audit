<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Transaction;
use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Transaction Categories
         */
        $organizationCategories = [
            'Pemasukan Organisasi',
            'Pengeluaran Organisasi',
            'Pemasukan Lainnya',
        ];

        $divisionCategories = [
            'Pengeluaran Divisi',
            'Pemasukan dari Organisasi',
        ];

        /**
         * Semua organisasi
         */
        $organizations = Organization::with([
            'divisions',
        ])->get();

        foreach ($organizations as $organization) {

            /**
             * Bendahara organisasi
             */
            $organizationTreasurerRole = OrganizationRole::where(
                'organization_id',
                $organization->id
            )
                ->where('scope', 'organization')
                ->where('name', 'Bendahara')
                ->first();

            $organizationTreasurer = UserOrganization::where(
                'organization_id',
                $organization->id
            )
                ->where('role_id', $organizationTreasurerRole?->id)
                ->first();

            /**
             * ORGANIZATION TRANSACTIONS
             */
            for ($i = 0; $i < rand(8, 15); $i++) {

                $category = fake()->randomElement(
                    $organizationCategories
                );

                Transaction::create([

                    'organization_id' => $organization->id,

                    'division_id' => null,

                    'category' => $category,

                    'amount' => fake()->numberBetween(
                        100000,
                        10000000
                    ),

                    'description' => fake()->sentence(),

                    'proof_url' => 'https://example.com',

                    /**
                     * Organization Transaction
                     * langsung approve
                     */
                    'status' => 'approved',

                    'created_by' => $organizationTreasurer?->user_id,

                    'approved_by' => $organizationTreasurer?->user_id,

                    'transaction_date' => Carbon::now()
                        ->subDays(rand(1, 90)),

                    'approved_at' => Carbon::now()
                        ->subDays(rand(1, 90)),
                ]);
            }

            /**
             * DIVISION TRANSACTIONS
             */
            foreach ($organization->divisions as $division) {

                /**
                 * Bendahara divisi
                 */
                $divisionTreasurerRole = OrganizationRole::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('scope', 'division')
                    ->where('name', 'Bendahara')
                    ->first();

                $divisionTreasurer = UserOrganization::where(
                    'organization_id',
                    $organization->id
                )
                    ->where('division_id', $division->id)
                    ->where('role_id', $divisionTreasurerRole?->id)
                    ->first();

                /**
                 * Random jumlah transaksi
                 */
                for ($j = 0; $j < rand(5, 10); $j++) {

                    $category = fake()->randomElement(
                        $divisionCategories
                    );

                    /**
                     * Jika pemasukan dari organisasi
                     * maka perlu approval
                     */
                    if ($category === 'Pemasukan dari Organisasi') {

                        $status = fake()->randomElement([
                            'pending',
                            'approved',
                            'rejected',
                        ]);

                        Transaction::create([

                            'organization_id' => $organization->id,

                            'division_id' => $division->id,

                            'category' => $category,

                            'amount' => fake()->numberBetween(
                                100000,
                                5000000
                            ),

                            'description' => fake()->sentence(),

                            'proof_url' => 'https://example.com',

                            'status' => $status,

                            'created_by' => $divisionTreasurer?->user_id,

                            /**
                             * approved oleh bendahara organization
                             */
                            'approved_by' => $status === 'pending'
                                ? null
                                : $organizationTreasurer?->user_id,

                            'transaction_date' => Carbon::now()
                                ->subDays(rand(1, 90)),

                            'approved_at' => $status === 'pending'
                                ? null
                                : Carbon::now()->subDays(rand(1, 90)),
                        ]);

                    } else {

                        /**
                         * Pengeluaran divisi
                         * langsung approve
                         */
                        Transaction::create([

                            'organization_id' => $organization->id,

                            'division_id' => $division->id,

                            'category' => $category,

                            'amount' => fake()->numberBetween(
                                100000,
                                3000000
                            ),

                            'description' => fake()->sentence(),

                            'proof_url' => 'https://example.com',

                            'status' => 'approved',

                            'created_by' => $divisionTreasurer?->user_id,

                            'approved_by' => $organizationTreasurer?->user_id,

                            'transaction_date' => Carbon::now()
                                ->subDays(rand(1, 90)),

                            'approved_at' => Carbon::now()
                                ->subDays(rand(1, 90)),
                        ]);
                    }
                }
            }
        }
    }
}