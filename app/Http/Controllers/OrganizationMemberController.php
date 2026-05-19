<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrganizationMemberController extends Controller
    {
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Organization $organization)
    {
        return view('pages.memberJoin.create', [
            'organization' => $organization,
        ]);
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'password_organizations' => 'required|string',
        ]);

        /**
         * Check Password
         */
        if (
            !Hash::check(
                $request->password_organizations,
                $organization->password_organizations
            )
        ) {
            return back()->withErrors([
                'password_organizations' => 'Kode organisasi salah.'
            ]);
        }

        /**
         * Already Joined
         */
        $exists = UserOrganization::where(
            'user_id',
            Auth::id()
        )
            ->where(
                'organization_id',
                $organization->id
            )
            ->exists();

        if ($exists) {

            return back()->with(
                'error',
                'Anda sudah bergabung dalam organisasi ini.'
            );
        }

        /**
         * Default Role
         */
        $role = OrganizationRole::where(
            'organization_id',
            $organization->id
        )
            ->where('scope', 'organization')
            ->where('name', 'Anggota')
            ->first();

        /**
         * Join Organization
         */
        UserOrganization::create([

            'user_id' => Auth::id(),

            'organization_id' => $organization->id,

            'role_id' => $role?->id,

            'division_id' => null,

        ]);

        return redirect()
        ->route(
            'organizations.show',
            $organization
        )
        ->with(
            'success',
            'Berhasil bergabung dengan organisasi.'
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
    public function update(Request $request, Organization $organization, string $id)
    {
        $request->validate([
            'role_id' => 'required|exists:organization_roles,id',
            'division_id' => 'nullable|exists:divisions,id',
        ]);

        $userOrganization = \App\Models\UserOrganization::where('organization_id', $organization->id)
            ->findOrFail($id);

        $userOrganization->update([
            'role_id' => $request->role_id,
            'division_id' => $request->division_id,
        ]);

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
