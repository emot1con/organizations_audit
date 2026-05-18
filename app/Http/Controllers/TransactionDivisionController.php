<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
    Division $division
    )
    {
        $transactions = $division->transactions()
            ->with([

                'createdBy',

                'approvedBy',

                'division',

            ])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->get();

        return view(
            'pages.transactions.index',
            [

                'organization' =>
                    $division->organization,

                'division' => $division,

                'transactions' => $transactions,

                'type' => 'division',

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create  (Division $division)
    {
        return view('pages.transactions.create', [
            'organization' => $division->organization,
            'division' => $division,
            'type' => 'division',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
    Request $request,
    Division $division
    )
    {
        /**
         * Validation
         */
        $validated = $request->validate([

            'category' => 'required|in:pengeluaran,pemasukan_organisasi,pemasukan_lainnya',

            'amount' => 'required|numeric|min:1',

            'transaction_date' => 'required|date',

            'proof_url' => 'nullable|url',

            'description' => 'nullable|string',

        ]);

        /**
         * Cek saldo divisi
         */
        if (
            $validated['category'] === 'pengeluaran'
            &&
            $validated['amount']
                > $division->division_cash
        ) {

            return back()
                ->withInput()
                ->withErrors([

                    'amount' =>
                        'Saldo divisi tidak cukup.',

                ]);
        }

        /**
         * Default status
         */
        $status = 'approved';

        /**
         * Request ke organisasi
         * perlu approval
         */
        if (
            $validated['category']
            === 'pemasukan_organisasi'
        ) {

            $status = 'pending';

        }

        /**
         * Create transaction
         */
        $transaction = Transaction::create([

            'organization_id' =>
                $division->organization_id,

            'division_id' =>
                $division->id,

            'created_by' =>
                Auth::id(),

            'approved_by' =>
                $status === 'approved'
                    ? Auth::id()
                    : null,

            'category' =>
                $validated['category'],

            'amount' =>
                $validated['amount'],

            'transaction_date' =>
                $validated['transaction_date'],

            'proof_url' =>
                $validated['proof_url'] ?? null,

            'description' =>
                $validated['description'] ?? null,

            'status' => $status,

        ]);

        /**
         * Update saldo jika approved
         */
        if ($status === 'approved') {

            /**
             * Pemasukan lainnya
             */
            if (
                $validated['category']
                === 'pemasukan_lainnya'
            ) {

                $division->increment(
                    'division_cash',
                    $validated['amount']
                );

            }

            /**
             * Pengeluaran
             */
            if (
                $validated['category']
                === 'pengeluaran'
            ) {

                $division->decrement(
                    'division_cash',
                    $validated['amount']
                );

            }

        }
        /**
         * Redirect
         */
        return redirect()
            ->route(
                'divisions.transactions.index',
                $division
            )
            ->with(
                'success',
                $status === 'approved'
                    ? 'Transaksi divisi berhasil dibuat.'
                    : 'Request transaksi berhasil dikirim.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(
    Division $division,
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

                'organization' =>
                    $division->organization,

                'division' => $division,

                'transaction' => $transaction,

                'type' => 'division',

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
