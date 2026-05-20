<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\Permission;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

    ])
    ->withCount([

        'userOrganizations as total_members' =>
            function ($query) {

                $query->whereNull(
                    'division_id'
                );

            }

    ])
    ->latest()
    ->get();

        return view('pages.organizations.index', [
            'organizations' => $organizations
        ]);
    }

    /**
     * Admin organizations list
     */
    public function adminIndex()
    {
        $organizations = Organization::latest()
            ->withCount('userOrganizations')
            ->get();

        return view(
            'pages.admin.organizations.index',
            compact('organizations')
        );
    }

    /**
     * Form create organization
     */
    public function create()
    {
        return view(
            'pages.organizations.create'
        );
    }

    /**
     * Menyimpan organization baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'photo' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'description' =>
                'nullable|string',

            'organizations_cash' =>
                'required|numeric|min:0',

            'contact' =>
                'nullable|string|max:255',

            'password_organizations' =>
                'required|string|min:4|max:255',

            'category_organizations' =>
                'required|string|max:255',

        ]);

        DB::beginTransaction();

        try {

            /**
             * Upload Photo
             */
            $photoPath = null;

            if ($request->hasFile('photo')) {

                /**
                 * Simpan file ke:
                 * storage/app/public/organizations
                 */
                $photoPath = $request
                    ->file('photo')
                    ->store(
                        'organizations',
                        'public'
                    );

            }

            /**
             * Buat organization
             */
            $organization = Organization::create([

                'name' =>
                    $validated['name'],

                'photo' =>
                    $photoPath,

                'description' =>
                    $validated['description']
                    ?? null,

                'contact' =>
                    $validated['contact']
                    ?? null,

                'organizations_cash' =>
                    $validated['organizations_cash']
                    ?? null,

                'category_organizations' =>
                    $validated['category_organizations'],

                'owner_id' =>
                    $request->user()->id,

                'password_organizations' =>
                    bcrypt(
                        $validated['password_organizations']
                    ),

            ]);

            /**
             * Buat role Ketua Umum
             */
            $adminRole = OrganizationRole::create([

                'organization_id' =>
                    $organization->id,

                'division_id' =>
                    null,

                'name' =>
                    'Ketua Umum',

                'scope' =>
                    'organization',

            ]);

            /**
             * Ambil seluruh permission organization
             */
            $permissions = Permission::where(
                    'scope',
                    'organization'
                )
                ->pluck('id')
                ->toArray();

            /**
             * Attach semua permission
             */
            $adminRole->permissions()->sync(
                $permissions
            );

            /**
             * Buat role Anggota
             */
            OrganizationRole::create([

                'organization_id' =>
                    $organization->id,

                'division_id' =>
                    null,

                'name' =>
                    'Anggota',

                'scope' =>
                    'organization',

            ]);

            /**
             * Owner otomatis jadi admin organisasi
             */
            $organization->userOrganizations()->create([

                'user_id' =>
                    Auth::id(),

                'role_id' =>
                    $adminRole->id,

                'division_id' =>
                    null,

            ]);

            DB::commit();

            return redirect()
                ->route(
                    'organizations.show',
                    $organization
                )
                ->with(
                    'success',
                    'Organisasi berhasil dibuat'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            dd(
                $e->getMessage()
            );

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
   public function update(
    Request $request,
    Organization $organization
    )
    {
        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'photo' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'description' =>
                'nullable|string',

            'contact' =>
                'nullable|string|max:255',

            'category_organizations' =>
                'required|string|max:255',

            'password_organizations' =>
                'nullable|string|min:4|max:255',

        ]);

        DB::beginTransaction();

        try {

            /**
             * Default photo lama
             */
            $photoPath = $organization->photo;

            /**
             * Upload photo baru
             */
            if ($request->hasFile('photo')) {

                /**
                 * Hapus photo lama
                 */
                if ($organization->photo) {

                    Storage::disk('public')
                        ->delete(
                            $organization->photo
                        );

                }

                /**
                 * Simpan photo baru
                 */
                $photoPath = $request
                    ->file('photo')
                    ->store(
                        'organizations',
                        'public'
                    );

            }

            /**
             * Update organization
             */
            $organization->update([

                'name' =>
                    $validated['name'],

                'photo' =>
                    $photoPath,

                'description' =>
                    $validated['description']
                    ?? null,

                'contact' =>
                    $validated['contact']
                    ?? null,

                'category_organizations' =>
                    $validated['category_organizations'],

                'password_organizations' =>
                    $validated['password_organizations']
                        ? bcrypt(
                            $validated['password_organizations']
                        )
                        : $organization->password_organizations,

            ]);

            DB::commit();

            return redirect()
                ->route(
                    'organizations.settings.index',
                    $organization
                )
                ->with(
                    'success',
                    'Organisasi berhasil diperbarui'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            dd(
                $e->getMessage()
            );

        }
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