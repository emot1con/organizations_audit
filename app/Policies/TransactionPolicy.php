<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\UserOrganization;

class TransactionPolicy
{
    private function getUserOrgRecord(User $user, $organizationId)
    {
        return UserOrganization::with('role')
            ->where('user_id', $user->id)
            ->where('organization_id', $organizationId)
            ->first();
    }

    public function viewAny(User $user, $organizationId): bool
    {
        // User is member of the organization
        return $this->getUserOrgRecord($user, $organizationId) !== null;
    }

    public function view(User $user, Transaction $transaction): bool
    {
        // Scope limit check: user must belong to transaction's organization
        $record = $this->getUserOrgRecord($user, $transaction->organization_id);
        if (! $record) return false;

        // Either global org access (admin/manager) or same division or they own it
        if ($record->role && in_array($record->role->name, ['admin', 'manager'])) {
            return true;
        }

        return $transaction->created_by === $user->id || $transaction->division_id === $record->division_id;
    }

    public function create(User $user, $organizationId): bool
    {
        return $this->getUserOrgRecord($user, $organizationId) !== null;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        // Owner logic: user is owner and transaction still 'pending'
        return $user->id === $transaction->created_by && $transaction->status === 'pending';
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->created_by && $transaction->status === 'pending';
    }

    public function changeStatus(User $user, Transaction $transaction): bool
    {
        $record = $this->getUserOrgRecord($user, $transaction->organization_id);
        if (! $record) return false;

        if ($record->role && in_array($record->role->name, ['admin', 'manager'])) {
            return true;
        }

        return false;
    }
}
