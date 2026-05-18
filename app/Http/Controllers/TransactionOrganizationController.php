<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Organization $organization)
    {
        $transactions = $organization->transactions()
            ->with([

                'createdBy',

                'approvedBy',

                'division',

            ])
            ->latest('transaction_date')
            ->get();

        return view(
            'pages.transactions.index',
            [

                'organization' => $organization,

                'transactions' => $transactions,

                'type' => 'organization',

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        return view('pages.transactions.create', [
            'organization' => $organization,
            'division' => null,
            'type' => 'organization',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(
    Organization $organization,
    Transaction $transaction
    )
    {
        $transaction->load([

            'division',
            'createdBy',
            'approvedBy',

        ]);

        return view(
            'pages.transactions.show',
            [

                'organization' => $organization,

                'transaction' => $transaction,

                'type' => 'organization',

            ]
        );
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
