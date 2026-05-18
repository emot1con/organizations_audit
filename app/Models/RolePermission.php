<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [

        'organization_role_id',

        'permission_id',

    ];

    /**
     * Role
     */
    public function role()
    {
        return $this->belongsTo(
            OrganizationRole::class,
            'organization_role_id'
        );
    }

    /**
     * Permission
     */
    public function permission()
    {
        return $this->belongsTo(
            Permission::class
        );
    }
}