<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\OrganizationRole;
use App\Models\Permission;
use Illuminate\Http\Request;

class DivisionRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(
    Division $division
    )
    {
        /**
         * Load organization
         */
        $division->load('organization');

        /**
         * Ambil seluruh role division
         */
        $roles = OrganizationRole::with([

                'permissions',

                'userOrganizations',

            ])
            ->where(
                'organization_id',
                $division->organization_id
            )
            ->where(
                'division_id',
                $division->id
            )
            ->where(
                'scope',
                'division'
            )
            ->get();

        /**
         * Ambil permission division
         */
        $permissions = Permission::where(
            'scope',
            'division'
        )->get();

        return view(
            'pages.roles.divisions.index',
            [

                'organization' =>
                    $division->organization,

                'division' =>
                    $division,

                'roles' =>
                    $roles,

                'permissions' =>
                    $permissions,

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
    Division $division
    )
    {
        /**
         * Load organization
         */
        $division->load('organization');

        /**
         * Ambil permissions division
         */
        $permissions = Permission::where(
            'scope',
            'division'
        )->get();

        return view(
            'pages.roles.divisions.create',
            [

                'organization' =>
                    $division->organization,

                'division' =>
                    $division,

                'permissions' =>
                    $permissions,

            ]
        );
    }

    public function store(
        Request $request,
        Division $division
    )
    {
        /**
         * Validation
         */
        $request->validate([

            'name' =>
                'required|string|max:255',

            'permissions' =>
                'nullable|array',

            'permissions.*' =>
                'exists:permissions,id',

        ]);

        /**
         * Create role
         */
        $role = OrganizationRole::create([

            'organization_id' =>
                $division->organization_id,

            'division_id' =>
                $division->id,

            'name' =>
                $request->name,

            'scope' =>
                'division',

        ]);

        /**
         * Attach permissions
         */
        $role->permissions()->sync(

            $request->permissions ?? []

        );

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'divisions.settings',
                $division
            )
            ->with(
                'success',
                'Role division berhasil dibuat.'
            );
    }

    public function updatePermissions(
    Request $request,
    Division $division
    )
    {
        /**
         * Ambil seluruh role division
         */
        $roles = OrganizationRole::where(
                'organization_id',
                $division->organization_id
            )
            ->where(
                'division_id',
                $division->id
            )
            ->where(
                'scope',
                'division'
            )
            ->get();

        /**
         * Sync permissions
         */
        foreach ($roles as $role) {

            /**
             * Ketua Divisi
             * tidak boleh diubah
             */
            if (
                strtolower($role->name)
                === 'ketua divisi'
            ) {

                continue;

            }

            $permissions =
                $request->permissions[$role->id]
                ?? [];

            $role->permissions()->sync(
                $permissions
            );

        }

        /**
         * Redirect
         */
        return back()->with(
            'success',
            'Permission division berhasil diperbarui.'
        );
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
