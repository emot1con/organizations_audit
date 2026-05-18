<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use Illuminate\Http\Request;

class OrganizationUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Organization $organization)
    {
        $organization->load([

            'divisions',

            'roles',

        ]);

        $members = $organization->userOrganizations()
        ->with([
            'user',
            'role',
        ])
        ->get()
        ->groupBy('user_id')
        ->map(function ($items) {

            return $items->firstWhere(
                'division_id',
                null
            ) ?? $items->first();

        })
        ->sortBy(function ($member) use ($organization) {

            return $organization->userOrganizations()
                ->where('role_id', $member->role_id)
                ->count();

        });

        return view(
            'pages.members.organizations.index',
            [

                'organization' => $organization,

                'members' => $members,

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
    Organization $organization,
    $member
    )
    {
        $member = $organization->userOrganizations()
            ->with([
                'user',
                'role',
            ])
            ->findOrFail($member);

        $roles = $organization->roles()
            ->where('scope', 'organization')
            ->whereNull('division_id')
            ->get();

        return view(
            'pages.members.organizations.edit',
            [
                'organization' => $organization,
                'member' => $member,
                'roles' => $roles,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
    Request $request,
    Organization $organization,
    $member
    )
    {
        $member = $organization->userOrganizations()
            ->with([
                'user',
                'role',
            ])
            ->findOrFail($member);

        $validated = $request->validate(
            [
                'role_id' => [
                    'required',
                    'exists:organization_roles,id',
                ],
            ],
            [
                'role_id.required' => 'Role organisasi wajib dipilih.',
                'role_id.exists' => 'Role organisasi tidak valid.',
            ]
        );

        $role = OrganizationRole::where('organization_id', $organization->id)
            ->where('scope', 'organization')
            ->whereNull('division_id')
            ->find($validated['role_id']);

        if (!$role) {

            return back()
                ->withErrors([
                    'role_id' => 'Role tidak termasuk role organisasi ini.',
                ])
                ->withInput();

        }

        if ($member->role?->name === 'Ketua Umum') {

            return back()
                ->withErrors([
                    'role_id' => 'Ketua Umum tidak dapat diubah.',
                ]);

        }

        $member->update([
            'role_id' => $role->id,
        ]);

        return redirect()
            ->route('organization.users.index', $organization)
            ->with(
                'success',
                'Role member berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
