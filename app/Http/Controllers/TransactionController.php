<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['category', 'creator', 'approver'])->get();
        return response()->json($transactions);
    }

    public function create($id) {
        // harus tau dulu ini ngambil dari organization atau division
        return view('pages.transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'division_id' => 'nullable|exists:divisions,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'proof_url' => 'nullable|url',
            'transaction_date' => 'required|date',
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['status'] = 'pending';

        $transaction = Transaction::create($validated);
        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['category', 'creator', 'approver'])->findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'proof_url' => 'nullable|url',
            'transaction_date' => 'sometimes|date',
        ]);

        $transaction->update($validated);
        return response()->json($transaction);
    }

    public function changeStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        if ($validated['status'] === 'approved') {
            $validated['approved_by'] = $request->user()->id;
            $validated['approved_at'] = now();
        }

        $transaction->update($validated);
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
