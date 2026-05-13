<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrganizationPageController extends Controller
{
    public function index()
    {
        $organizations = Organization::with([
            'userOrganizations'
        ])->latest()->get();

        return view('pages.organizations.index', [
            'organizations' => $organizations
        ]);
    }

    public function create()
    {
        return view('pages.organizations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizations_cash' => 'required|integer',
            'contact' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            $adminRole = OrganizationRole::firstOrCreate([
                'name' => 'admin',
                'scope' => 'organization'
            ]);

            $organization = Organization::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'contact' => $validated['contact'] ?? null,
                'organizations_cash' => $validated['organizations_cash'],
            ]);

            UserOrganization::create([
                'user_id' => Auth::id(),
                'organization_id' => $organization->id,
                'role_id' => $adminRole->id,
                'division_id' => null,
            ]);

            DB::commit();

            return redirect()
                ->route('organizations.show', $organization)
                ->with('success', 'Organisasi berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }

    public function show(Organization $organization)
    {
        $organization->load([
            'divisions',
            'userOrganizations.user',
        ]);

        return view('pages.organizations.show', [
            'organization' => $organization
        ]);
    }

    public function edit(Organization $organization)
    {
        //
    }

    public function update(Request $request, Organization $organization)
    {
        //
    }

    public function destroy(Organization $organization)
    {
        //
    }
}