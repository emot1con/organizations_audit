<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'category',
        'division_cash',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
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