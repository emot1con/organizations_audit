<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\Permission;
use App\Models\Transaction;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionController extends Controller
{
    /**
     * List division dalam organization
     */
    public function index(Organization $organization)
    {
        $this->authorizeOrganizationAccess($organization);

        $organization->load([

            'divisions.userOrganizations',

            'divisions.roles',

        ]);

        return view(
            'pages.divisions.index',
            compact('organization')
        );
    }

    /**
     * Form create division
     */
    public function create(Organization $organization)
    {
        $this->authorizeOrganizationAccess($organization);

        return view('pages.divisions.create', [
            'organization' => $organization,
        ]);
    }

    /**
     * Store division
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

            'category' => 'required|in:tetap,sementara',

        ]);

        /**
         * Create Division
         */
        $division = Division::create([

            'organization_id' => $organization->id,

            'name' => $request->name,

            'category' => $request->category,

            'division_cash' => 0,

        ]);

        /**
         * Default Role Division
         * Ketua Divisi
         */
        $role = OrganizationRole::firstOrCreate([

            'organization_id' => $organization->id,

            'division_id' => $division->id,

            'name' => 'Ketua Divisi',

            'scope' => 'division',

        ]);

        /**
         * Default Role Division
         * Anggota
         */
        $memberRole = OrganizationRole::firstOrCreate([

            'organization_id' => $organization->id,

            'division_id' => $division->id,

            'name' => 'Anggota',

            'scope' => 'division',

        ]);

        /**
         * Full permissions
         * untuk ketua divisi
         */
        $divisionPermissions = Permission::where(
            'scope',
            'division'
        )->pluck('id');

        $role->permissions()->sync(
            $divisionPermissions
        );

        /**
         * Auto Join Creator
         */
        UserOrganization::create([

            'user_id' => Auth::id(),

            'organization_id' => $organization->id,

            'role_id' => $role->id,

            'division_id' => $division->id,

        ]);

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'organizations.show',
                $organization
            )
            ->with(
                'success',
                'Divisi berhasil dibuat'
            );
    }

    /**
     * Detail division
     */
    public function show(Division $division)
    {
        // $this->authorizeDivisionAccess($division);

        $division->load([

            'organization',

            'userOrganizations.user',

            'userOrganizations.role',

        ]);

        /**
         * Cek user sudah join
         */
        $isJoined = $division->userOrganizations()
            ->where(
                'user_id',
                Auth::id()
            )
            ->exists();

            /**
         * Cek ketua umum
         */
        $isOwner = $division->organization
            ->owner_id === Auth::id();

        return view(
            'pages.divisions.show',
            [

                'division' => $division,

                'isJoined' => $isJoined,

                'isOwner' => $isOwner,

            ]
        );
    }
    /**
     * Form edit division
     */
    public function edit(
    Division $division
    )
    {
        $organization = $division->organization;

        $this->authorizeOrganizationAccess(
            $organization
        );

        return view(
            'pages.divisions.edit',
            [

                'organization' =>
                    $organization,

                'division' =>
                    $division,

            ]
        );
    }

    /**
     * Update division
     */
    public function update(Request $request, Division $division)
    {
        $organization = $division->organization;

        $this->authorizeOrganizationAccess(
            $organization
        );

        /**
         * Validation
         */
        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'category' =>
                'required|string|max:255',

        ]);

        /**
         * Update Division
         */
        $division->update([

            'name' =>
                $validated['name'],

            'category' =>
                 $validated['category'],

        ]);

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'divisions.show',
                $division
            )
            ->with(
                'success',
                'Divisi berhasil diupdate.'
            );
    }

    /**
     * Delete division
     */
    public function destroy(
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
         * Hapus seluruh member division
         */
        UserOrganization::where(
                'division_id',
                $division->id
            )
            ->delete();

        /**
         * Hapus seluruh permission role
         */
        foreach ($roles as $role) {

            $role->permissions()->detach();

        }

        /**
         * Hapus transaksi division
         */
        Transaction::where(
            'division_id',
            $division->id
        )->delete();

        /**
         * Hapus seluruh role division
         */
        OrganizationRole::where(
                'division_id',
                $division->id
            )
            ->delete();

        /**
         * Hapus division
         */
        $division->delete();

        /**
         * Redirect
         */
        return redirect()
            ->route(
                'organizations.show',
                $division->organization_id
            )
            ->with(
                'success',
                'Divisi berhasil dihapus.'
            );
    }

    /**
     * Authorization organization access
     */
    private function authorizeOrganizationAccess(Organization $organization)
    {
        $isMember = UserOrganization::where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->exists();

        $isOwner = $organization->owner_id === Auth::id();

        if (!$isMember && !$isOwner) {
            abort(403);
        }
    }

    /**
     * Authorization division access
     */
    private function authorizeDivisionAccess(Division $division)
    {
        $isMember = UserOrganization::where('user_id', Auth::id())
            ->where('organization_id', $division->organization_id)
            ->exists();

        $isOwner = $division->organization->owner_id === Auth::id();

        if (!$isMember && !$isOwner) {
            abort(403);
        }
    }

    public function join(
    Division $division
    )
    {
        /**
         * Cari member organization
         */
        $member = UserOrganization::where(

            'organization_id',
            $division->organization_id

        )
            ->where(
                'user_id',
                Auth::id()
            )
            ->first();

        /**
         * Belum join organization
         */
        if (!$member) {

            return back()->withErrors([

                'error' =>
                    'Kamu belum tergabung di organisasi.'

            ]);

        }

        /**
         * Sudah join division
         */
        if ($member->division_id) {

            return back()->withErrors([

                'error' =>
                    'Kamu sudah tergabung di divisi.'

            ]);

        }

        /**
         * Ambil role anggota divisi
         */
        $role = $division->roles()
            ->where(
                'name',
                'Anggota'
            )
            ->first();

        if (!$role) {

            return back()->withErrors([

                'error' =>
                    'Role anggota divisi tidak ditemukan.'

            ]);

        }

        /**
         * Update division member
         */
        $member->update([

            'division_id' =>
                $division->id,

            'role_id' =>
                $role->id,

        ]);

        return back()->with(
            'success',
            'Berhasil join divisi.'
        );
    }
}