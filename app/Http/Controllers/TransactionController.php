<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

class TransactionController extends Controller
{
    #[OA\Get(
        path: "/api/organizations/{org_id}/transactions",
        summary: "Get list of transactions (Paginated)",
        security: [["sanctum" => []]],
        tags: ["Transactions"],
        parameters: [
            new OA\Parameter(name: "org_id", in: "path", required: true, description: "Organization ID", schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "month", in: "query", required: false, schema: new OA\Schema(type: "integer", minimum: 1, maximum: 12)),
            new OA\Parameter(name: "year", in: "query", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "status", in: "query", required: false, schema: new OA\Schema(type: "string", enum: ["pending", "approved", "rejected"])),
            new OA\Parameter(name: "page", in: "query", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "List of transactions paginated")
        ]
    )]
    public function index(Request $request, $organization)
    {
        Gate::authorize('viewAny', [Transaction::class, $organization]);

        $userOrg = UserOrganization::with('role')
            ->where('user_id', $request->user()->id)
            ->where('organization_id', $organization)
            ->first();

        $query = Transaction::with(['category', 'creator', 'approver', 'division'])
            ->where('organization_id', $organization);

        $roleName = $userOrg->role ? $userOrg->role->name : 'member';
        if (!in_array($roleName, ['admin', 'manager'])) {
            $query->where(function($q) use ($request, $userOrg) {
                $q->where('created_by', $request->user()->id);
                if ($userOrg->division_id) {
                    $q->orWhere('division_id', $userOrg->division_id);
                }
            });
        }

        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('transaction_date', $request->year);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest('transaction_date')->paginate(15);
        return response()->json($transactions);
    }

    public function create($id) {
        // harus tau dulu ini ngambil dari organization atau division
        return view('pages.transactions.create');
    }

    public function store(Request $request)
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

    #[OA\Get(
        path: "/api/transactions/{id}",
        summary: "Get specific transaction details",
        security: [["sanctum" => []]],
        tags: ["Transactions"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "Transaction ID", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Transaction detail"),
            new OA\Response(response: 403, description: "Unauthorized access"),
            new OA\Response(response: 404, description: "Not found")
        ]
    )]
    public function show($id)
    {
        $transaction = Transaction::with(['category', 'creator', 'approver', 'division'])->findOrFail($id);
        Gate::authorize('view', $transaction);
        
        return response()->json($transaction);
    }

    #[OA\Put(
        path: "/api/transactions/{id}",
        summary: "Update existing transaction (Full/Partial)",
        security: [["sanctum" => []]],
        tags: ["Transactions"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "category_id", type: "integer"),
                    new OA\Property(property: "amount", type: "number", format: "float"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "proof_url", type: "string", format: "uri"),
                    new OA\Property(property: "transaction_date", type: "string", format: "date")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Updated transaction"),
            new OA\Response(response: 403, description: "Unauthorized access")
        ]
    )]
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

    #[OA\Patch(
        path: "/api/transactions/{id}/status",
        summary: "Update transaction status",
        security: [["sanctum" => []]],
        tags: ["Transactions"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["status"],
                properties: [
                    new OA\Property(property: "status", type: "string", enum: ["pending", "approved", "rejected"])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Status updated successfully"),
            new OA\Response(response: 403, description: "Only admins or managers can update status")
        ]
    )]
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

    #[OA\Delete(
        path: "/api/transactions/{id}",
        summary: "Delete a transaction",
        security: [["sanctum" => []]],
        tags: ["Transactions"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Transaction deleted"),
            new OA\Response(response: 403, description: "Unauthorized")
        ]
    )]
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        Gate::authorize('delete', $transaction);
        
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
