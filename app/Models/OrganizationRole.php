<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'scope',
    ];

    public function userOrganizations()
    {
        return $this->hasMany(UserOrganization::class, 'role_id');
    }
}