<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use App\Models\OrganizationRole;
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
        

        return view('pages.divisions.show', compact('division'));
    }

    /**
     * Form edit division
     */
    public function edit(
    Organization $organization,
    Division $division
    )
    {
        $this->authorizeOrganizationAccess($organization);

        if ($division->organization_id !== $organization->id) {

            abort(404);

        }

        return view(
            'pages.divisions.edit',
            [
                'organization' => $organization,
                'division' => $division,
            ]
        );
    }

    /**
     * Update division
     */
    public function update(Request $request, Division $division)
    {
        $this->authorizeDivisionAccess($division);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $division->update([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return redirect()
            ->route('divisions.show', $division)
            ->with('success', 'Divisi berhasil diupdate');
    }

    /**
     * Delete division
     */
    public function destroy(Division $division)
    {
        $this->authorizeDivisionAccess($division);

        $organization = $division->organization;

        $division->delete();

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Divisi berhasil dihapus');
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
}