<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'division_id',
        'name',
        'scope',
    ];

    /**
     * Organization Owner
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Optional Division
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Users with this role
     */
    public function userOrganizations()
    {
        return $this->hasMany(UserOrganization::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions'
        );
    }
}