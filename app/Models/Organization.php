<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'organizations_cash',
        'contact',
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function userOrganizations()
    {
        return $this->hasMany(UserOrganization::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
