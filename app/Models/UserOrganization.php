<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOrganization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
        'role_id',
        'division_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function role()
    {
        return $this->belongsTo(OrganizationRole::class, 'role_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }


}