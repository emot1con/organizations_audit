<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $organization)
    {
        $roles = $organization->roles()
            ->where('scope', 'organization')
            ->whereNull('division_id')
            ->withCount('userOrganizations')
            ->orderBy('user_organizations_count')
            ->get();

        return view(
            'pages.roles.organizations.index',
            [
                'organization' => $organization,
                'roles' => $roles,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        return view(
            'pages.roles.organizations.create',
            compact('organization')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
