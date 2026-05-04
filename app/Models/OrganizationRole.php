<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationRole extends Model
{
    protected $fillable = [
        'name',
        'scope',
    ];

    public function userOrganizations()
    {
        return $this->hasMany(UserOrganization::class, 'role_id');
    }
}
