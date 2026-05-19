<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Http\Request;

class DivisionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
    Division $division
    )
    {
        $division->load([

            'organization',

            'roles',

        ]);

        $members = $division->userOrganizations()
            ->whereNotNull('division_id')
            ->with([

                'user',

                'role',

            ])
            ->get();

        return view(
            'pages.members.divisions.index',
            [

                'organization' =>
                    $division->organization,

                'division' =>
                    $division,

                'members' =>
                    $members,

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function edit(
    Division $division,
    UserOrganization $member
    )
    {
        /**
         * Load relation
         */
        $member->load([

            'user',

            'role',

        ]);

        /**
         * Ambil role division
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

        return view(
            'pages.members.divisions.edit',
            [

                'organization' =>
                    $division->organization,

                'division' =>
                    $division,

                'member' =>
                    $member,

                'roles' =>
                    $roles,

            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
    Request $request,
    Division $division,
    UserOrganization $member
    )
    {
        /**
         * Validation
         */
        $validated = $request->validate([

            'role_id' =>
                'required|exists:organization_roles,id',

        ]);

        /**
         * Ambil role
         */
        $role = OrganizationRole::where(

                'organization_id',
                $division->organization_id

            )
            ->where(
                'division_id',
                $division->id
            )
            ->where(
                'id',
                $validated['role_id']
            )
            ->first();

        /**
         * Role tidak ditemukan
         */
        if (!$role) {

            return back()->withErrors([

                'error' =>
                    'Role division tidak valid.'

            ]);

        }

        /**
         * Ketua divisi tidak boleh diubah
         */
        if (
            strtolower($member->role->name)
            === 'ketua divisi'
        ) {

            return back()->withErrors([

                'error' =>
                    'Ketua divisi tidak dapat diubah.'

            ]);

        }

        /**
         * Update role
         */
        $member->update([

            'role_id' =>
                $validated['role_id'],

        ]);

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'division.users.index',
                $division
            )
            ->with(
                'success',
                'Role member division berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
    Division $division,
    UserOrganization $member
    )
    {
        /**
         * Tidak boleh keluarkan
         * ketua divisi
         */
        if (
            strtolower($member->role?->name)
            === 'ketua divisi'
        ) {

            return back()->withErrors([

                'error' =>
                    'Ketua divisi tidak dapat dikeluarkan.'

            ]);

        }

        /**
         * Pastikan member
         * berasal dari divisi ini
         */
        if (
            $member->division_id
            !== $division->id
        ) {

            abort(404);

        }

        /**
         * Ambil role anggota organization
         */
        $organizationRole = OrganizationRole::where(

                'organization_id',
                $division->organization_id

            )
            ->where(
                'scope',
                'organization'
            )
            ->whereNull('division_id')
            ->where(
                'name',
                'Anggota'
            )
            ->first();

        /**
         * Role organization tidak ditemukan
         */
        if (!$organizationRole) {

            return back()->withErrors([

                'error' =>
                    'Role anggota organisasi tidak ditemukan.'

            ]);

        }

        /**
         * Keluarkan dari division
         */
        $member->update([

            'division_id' =>
                null,

            'role_id' =>
                $organizationRole->id,

        ]);

        /**
         * Redirect
         */
        return back()->with(
            'success',
            'Member berhasil dikeluarkan dari divisi.'
        );
    }
}
