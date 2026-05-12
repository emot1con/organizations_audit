<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Organization;
use App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'division_id' => null,
            'category_id' => Category::factory(),
            'amount' => 50000,
            'description' => 'Transaksi dummy',
            'proof_url' => 'dummy.jpg',
            'status' => 'pending',
            'created_by' => User::factory(),
            'approved_by' => User::factory(),
            'transaction_date' => now(),
            'approved_at' => now(),
        ];
    }
}