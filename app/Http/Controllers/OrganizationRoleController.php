<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\Permission;
use App\Models\UserOrganization;
use Illuminate\Http\Request;

class OrganizationRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $organization)
    {
        $organization->load([

            'roles.permissions',

            'roles.userOrganizations',

        ]);

        $permissions = Permission::where(
            'scope',
            'organization'
        )->get();

        return view(
            'pages.roles.organizations.index',
            [

                'organization' => $organization,

                'roles' => $organization->roles
                    ->where('scope', 'organization'),

                'permissions' => $permissions,

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        $permissions = Permission::where(
            'scope',
            'organization'
        )->get();

        return view(
            'pages.roles.organizations.create',
            [

                'organization' => $organization,

                'permissions' => $permissions,

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
    Request $request,
    Organization $organization
    )
    {
        /**
         * Validation
         */
        $request->validate([

            'name' => 'required|string|max:255',

            'permissions' => 'nullable|array',

            'permissions.*' => 'exists:permissions,id',

        ]);

        /**
         * Create Role
         */
        $role = OrganizationRole::create([

            'organization_id' => $organization->id,

            'division_id' => null,

            'name' => $request->name,

            'scope' => 'organization',

        ]);

        /**
         * Attach Permissions
         */
        $role->permissions()->sync(

            $request->permissions ?? []

        );

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'organizations.settings.index',
                $organization
            )
            ->with(
                'success',
                'Role organization berhasil dibuat.'
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
    public function updatePermissions(
    Request $request,
    Organization $organization
    )
    {
        $roles = OrganizationRole::where(
            'organization_id',
            $organization->id
        )
            ->where('scope', 'organization')
            ->get();

        foreach ($roles as $role) {

            $isProtected = in_array(
                strtolower($role->name),
                [

                    'ketua umum',

                    'owner',

                ]
            );

            if ($isProtected) {

                continue;

            }

            $permissions = $request->permissions[$role->id] ?? [];

            $role->permissions()->sync(
                $permissions
            );
        }

        return back()->with(
            'success',
            'Permission berhasil diperbarui.'
        );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
    Organization $organization,
    OrganizationRole $role
    )
    {
        /**
         * Tidak boleh hapus owner
         */
        if (
            strtolower($role->name)
            === 'owner'
        ) {

            return back()->withErrors([

                'error' =>
                    'Role owner tidak dapat dihapus.'

            ]);

        }

        /**
         * Ambil role anggota
         */
        $memberRole = OrganizationRole::where(

                'organization_id',
                $organization->id

            )
            ->where(
                'scope',
                'organization'
            )
            ->where(
                'name',
                'Anggota'
            )
            ->first();

        /**
         * Role anggota tidak ditemukan
         */
        if (!$memberRole) {

            return back()->withErrors([

                'error' =>
                    'Role anggota tidak ditemukan.'

            ]);

        }

        /**
         * Pindahkan seluruh member
         * ke role anggota
         */
        UserOrganization::where(
                'role_id',
                $role->id
            )
            ->update([

                'role_id' =>
                    $memberRole->id,

            ]);

        /**
         * Hapus permissions
         */
        $role->permissions()->detach();

        /**
         * Hapus role
         */
        $role->delete();

        /**
         * Redirect
         */
        return back()->with(
            'success',
            'Role berhasil dihapus.'
        );
    }
}
