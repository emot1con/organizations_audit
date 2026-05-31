<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(
    Request $request,
    Organization $organization
    )
    {
        $transactions = $organization->transactions()

            ->with([
                'createdBy',
                'approvedBy',
                'division',
            ])

            ->when(
                $request->start_date,
                function ($query) use ($request) {

                    $query->whereDate(
                        'transaction_date',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function ($query) use ($request) {

                    $query->whereDate(
                        'transaction_date',
                        '<=',
                        $request->end_date
                    );

                }
            )

            ->orderByDesc('transaction_date')

            ->orderByDesc('id')

            ->get();

        return view(
            'pages.transactions.index',
            [

                'organization' =>
                    $organization,

                'transactions' =>
                    $transactions,

                'type' =>
                    'organization',

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
    public function store(
    Request $request,
    Organization $organization
    )
    {
        /**
         * Validation
         */
        $validated = $request->validate([

            'category' => 'required|in:pemasukan,pengeluaran',

            'amount' => 'required|numeric|min:1',

            'transaction_date' => 'required|date',

            'proof_url' => 'nullable|url',

            'description' => 'nullable|string',

        ]);

        /**
         * Cek saldo organization
         */
        if (
            $validated['category'] === 'pengeluaran'
            &&
            $validated['amount']
                > $organization->organizations_cash
        ) {

            return back()
                ->withInput()
                ->withErrors([

                    'amount' =>
                        'Saldo organisasi tidak cukup.',

                ]);
        }

        /**
         * Create transaction
         */
        $transaction = Transaction::create([

            'organization_id' => $organization->id,

            'division_id' => null,

            'created_by' => Auth::id(),

            'approved_by' => Auth::id(),

            'category' => $validated['category'],

            'amount' => $validated['amount'],

            'transaction_date' =>
                $validated['transaction_date'],

            'proof_url' =>
                $validated['proof_url'] ?? null,

            'description' =>
                $validated['description'] ?? null,

            'status' => 'approved',

        ]);

        /**
         * Update saldo
         */
        if ($validated['category'] === 'pemasukan') {

            $organization->increment(
                'organizations_cash',
                $validated['amount']
            );

        } else {

            $organization->decrement(
                'organizations_cash',
                $validated['amount']
            );

        }

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'organizations.transactions.index',
                $organization
            )
            ->with(
                'success',
                'Transaksi organisasi berhasil dibuat.'
            );
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

   public function print(
    Request $request,
    Organization $organization
    )
    {
        $transactions = $organization->transactions()

            ->with([
                'createdBy',
                'approvedBy',
                'division',
            ])

            ->where(
                'status',
                'approved'
            )

            ->when(
                $request->start_date,
                function ($query) use ($request) {

                    $query->whereDate(
                        'transaction_date',
                        '>=',
                        $request->start_date
                    );

                }
            )

            ->when(
                $request->end_date,
                function ($query) use ($request) {

                    $query->whereDate(
                        'transaction_date',
                        '<=',
                        $request->end_date
                    );

                }
            )

            ->orderBy(
                'transaction_date'
            )

            ->get();

        /**
         * Total pemasukan
         */
        $totalIncome = $transactions

            ->filter(function ($transaction) {

                return str_contains(
                    strtolower($transaction->category),
                    'pemasukan'
                );

            })

            ->sum('amount');

        /**
         * Total pengeluaran
         */
        $totalExpense = $transactions

            ->filter(function ($transaction) {

                return str_contains(
                    strtolower($transaction->category),
                    'pengeluaran'
                );

            })

            ->sum('amount');

        /**
         * Saldo
         */
        $balance =
            $totalIncome -
            $totalExpense;

        return view(
            'pages.transactions.organization-print',
            [

                'organization' =>
                    $organization,

                'transactions' =>
                    $transactions,

                'totalIncome' =>
                    $totalIncome,

                'totalExpense' =>
                    $totalExpense,

                'balance' =>
                    $balance,

                'printedBy' =>
                    Auth::user(),

                'startDate' =>
                    $request->start_date,

                'endDate' =>
                    $request->end_date,

            ]
        );
    }

    public function approve(
    Organization $organization,
    Transaction $transaction
    )
    {
        /**
         * Pastikan transaction pending
         */
        if ($transaction->status !== 'pending') {

            return back()->withErrors([

                'error' =>
                    'Transaksi sudah diproses.'

            ]);

        }

        /**
         * Pastikan category request organisasi
         */
        if (
            $transaction->category
            !== 'pemasukan_organisasi'
        ) {

            return back()->withErrors([

                'error' =>
                    'Transaksi tidak valid.'

            ]);

        }

        /**
         * Cek saldo organisasi
         */
        if (
            $transaction->amount
            > $organization->organizations_cash
        ) {

            return back()->withErrors([

                'error' =>
                    'Saldo organisasi tidak cukup.'

            ]);

        }

        /**
         * Update saldo organization
         */
        $organization->decrement(
            'organizations_cash',
            $transaction->amount
        );

        /**
         * Update saldo division
         */
        $transaction->division->increment(
            'division_cash',
            $transaction->amount
        );

        /**
         * Approve transaction
         */
        $transaction->update([

            'status' => 'approved',

            'approved_by' => Auth::id(),

            'approved_at' => now(),

        ]);

        /**
         * Redirect
         */
        return back()->with(
            'success',
            'Transaksi berhasil diapprove.'
        );
    }



    public function reject(
    Organization $organization,
    Transaction $transaction
    )
    {
        /**
         * Pastikan transaction pending
         */
        if ($transaction->status !== 'pending') {

            return back()->withErrors([

                'error' =>
                    'Transaksi sudah diproses.'

            ]);

        }

        /**
         * Reject transaction
         */
        $transaction->update([

            'status' => 'rejected',

            'approved_by' => Auth::id(),

            'approved_at' => now(),

        ]);

        /**
         * Redirect
         */
        return back()->with(
            'success',
            'Transaksi berhasil ditolak.'
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
