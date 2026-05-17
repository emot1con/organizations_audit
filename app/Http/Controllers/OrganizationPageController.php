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
    /**
     * Menampilkan daftar organisasi
     */
    public function index()
    {
        $organizations = Organization::with([
            'owner',
            'userOrganizations',
        ])->latest()->get();

        return view('pages.organizations.index', [
            'organizations' => $organizations
        ]);
    }

    /**
     * Form create organization
     */
    public function create()
    {
        return view('pages.organizations.create');
    }

    /**
     * Menyimpan organization baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizations_cash' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {

            /**
             * Cari / buat role admin organization
             */
            $adminRole = OrganizationRole::firstOrCreate([
                'name' => 'admin',
                'scope' => 'organization',
            ]);

            /**
             * Buat organization
             */
            $organization = Organization::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'contact' => $validated['contact'] ?? null,
                'organizations_cash' => $validated['organizations_cash'],
                'owner_id' => Auth::id(),
            ]);

            /**
             * Owner otomatis jadi admin organisasi
             */
            $organization->userOrganizations()->create([
                'user_id' => Auth::id(),
                'role_id' => $adminRole->id,
                'division_id' => null,
            ]);

            DB::commit();
            return redirect()
                ->route('organizations.show', $organization)
                ->with('success', 'Organisasi berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();
            dd($e->getMessage());


            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage()
                ]);
        }
    }

    /**
     * Detail organization
     */
    public function show(Organization $organization)
    {
        /**
         * Authorization
         */
        $isMember = UserOrganization::where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->exists();

        $isOwner = $organization->owner_id === Auth::id();

        if (!$isMember && !$isOwner) {
            abort(403);
        }

        /**
         * Load relasi
         */
        $organization->load([
            'owner',
            'divisions.userOrganizations',
            'divisions.roles',
            'userOrganizations.user',
        ]);

        return view('pages.organizations.show', [
            'organization' => $organization
        ]);
    }

    /**
     * Form edit organization
     */
    public function edit(Organization $organization)
    {
        return view('pages.organizations.edit', [
            'organization' => $organization
        ]);
    }

    /**
     * Update organization
     */
    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizations_cash' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:255',
        ]);

        $organization->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'organizations_cash' => $validated['organizations_cash'],
            'contact' => $validated['contact'] ?? null,
        ]);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organisasi berhasil diupdate');
    }

    /**
     * Delete organization
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organisasi berhasil dihapus');
    }
}