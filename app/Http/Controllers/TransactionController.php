<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function index(Request $request, $organization)
    {
        // Otentikasi: User harus terdaftar di organisasi ini
        Gate::authorize('viewAny', [Transaction::class, $organization]);

        // Cek Role User di Organisasi tersebut
        $userOrg = UserOrganization::with('role')
            ->where('user_id', $request->user()->id)
            ->where('organization_id', $organization)
            ->first();

        $query = Transaction::with(['category', 'creator', 'approver', 'division'])
            ->where('organization_id', $organization);

        // Skoping Data: Jika bukan admin/manager, ia hanya melihat milik divisinya atau miliknya sendiri
        $roleName = $userOrg->role ? $userOrg->role->name : 'member';
        if (!in_array($roleName, ['admin', 'manager'])) {
            $query->where(function($q) use ($request, $userOrg) {
                $q->where('created_by', $request->user()->id);
                if ($userOrg->division_id) {
                    $q->orWhere('division_id', $userOrg->division_id);
                }
            });
        }

        // Filtering: Month & Year (Opsional via Query param)
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Fitur Pagination bawaan laravel
        $transactions = $query->latest('transaction_date')->paginate(15);
        return response()->json($transactions);
    }

    public function store(Request $request, $organization)
    {
        Gate::authorize('create', [Transaction::class, $organization]);

        $validated = $request->validate([
            'division_id' => [
                'nullable', 
                'exists:divisions,id'
            ],
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'proof_url' => 'nullable|url',
            'transaction_date' => 'required|date',
        ]);

        // Cross Validation: Mengecek division_id terikat ke organization yg sama (Mencegah Bypass Hack)
        if ($request->filled('division_id')) {
            $isValidDivision = \App\Models\Division::where('id', $validated['division_id'])
                               ->where('organization_id', $organization)
                               ->exists();
            if (! $isValidDivision) {
                return response()->json(['message' => 'Divisi ini bukan milik organisasi tersebut.'], 403);
            }
        }

        $validated['organization_id'] = $organization;
        $validated['created_by'] = $request->user()->id;
        $validated['status'] = 'pending';

        $transaction = Transaction::create($validated);
        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['category', 'creator', 'approver', 'division'])->findOrFail($id);
        Gate::authorize('view', $transaction);
        
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        Gate::authorize('update', $transaction);
        
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
        Gate::authorize('changeStatus', $transaction);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        if ($validated['status'] === 'approved') {
            $validated['approved_by'] = $request->user()->id;
            $validated['approved_at'] = now();
        } elseif ($validated['status'] === 'pending') {
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        $transaction->update($validated);
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        Gate::authorize('delete', $transaction);
        
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
