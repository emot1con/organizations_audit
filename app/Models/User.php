<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function userOrganizations()
    {
        return $this->hasMany(UserOrganization::class);
    }

    public function approvedTransactions()
    {
        return $this->hasMany(Transaction::class, 'approved_by');
    }

    public function createdTransactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function hasDivisionPermission(
    $divisionId,
    $permissionName
    )
    {
        $membership = $this->userOrganizations()

            ->with('role.permissions')

            ->where(
                'division_id',
                $divisionId
            )
            ->first();

        /**
         * Tidak punya membership division
         */
        if (
            !$membership
            ||
            !$membership->role
        ) {

            return false;

        }

        /**
         * Pastikan role division
         */
        if (
            $membership->role->scope
            !== 'division'
        ) {

            return false;

        }

        /**
         * Cek permission
         */
        return $membership->role
            ->permissions
            ->pluck('name')
            ->contains($permissionName);
    }

    public function hasOrganizationPermission(
    $organizationId,
    $permissionName
    )
    {
        $membership = $this->userOrganizations()

            ->with('role.permissions')

            ->where(
                'organization_id',
                $organizationId
            )
            ->whereNull(
                'division_id'
            )
            ->first();

        /**
         * Tidak punya membership organization
         */
        if (
            !$membership
            ||
            !$membership->role
        ) {

            return false;

        }

        /**
         * Pastikan role organization
         */
        if (
            $membership->role->scope
            !== 'organization'
        ) {

            return false;

        }

        /**
         * Cek permission
         */
        return $membership->role
            ->permissions
            ->pluck('name')
            ->contains($permissionName);
    }
}
