<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
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

        $organization->load('divisions');

        return view('divisions.index', compact('organization'));
    }

    /**
     * Form create division
     */
    public function create(Organization $organization)
    {
        $this->authorizeOrganizationAccess($organization);

        return view('divisions.create', compact('organization'));
    }

    /**
     * Store division
     */
    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $isAdmin = UserOrganization::where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->whereHas('role', function ($q) {
                $q->where('name', 'admin')
                  ->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        $isOwner = $organization->owner_id === Auth::id();

        if (!$isAdmin && !$isOwner) {
            abort(403);
        }

        Division::create([
            'organization_id' => $organization->id,
            'name' => $request->name,
            'category' => $request->category,
            'division_cash' => 0,
        ]);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Divisi berhasil dibuat');
    }

    /**
     * Detail division
     */
    public function show(Division $division)
    {
        $this->authorizeDivisionAccess($division);

        $division->load([
            'organization',
            'userOrganizations.user',
            'transactions',
        ]);

        return view('pages.divisions.show', compact('division'));
    }

    /**
     * Form edit division
     */
    public function edit(Division $division)
    {
        $this->authorizeDivisionAccess($division);

        return view('divisions.edit', compact('division'));
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