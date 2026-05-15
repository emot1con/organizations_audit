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
        $organization->load([
            'transactions',
        ]);

        return view('pages.transactions.index', [
            'organization' => $organization,
            'transactions' => $organization->transactions,
            'type' => 'organization',
        ]);

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
    public function show($organization, $transaction)
    {
        return view('pages.transactions.show', [
            'type' => 'organization',
        ]);
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
