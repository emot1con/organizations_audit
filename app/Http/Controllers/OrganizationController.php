<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\Transaction;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    // Mengambil daftar organisasi milik user yang sedang login
    public function index(Request $request)
    {
        // Mengambil data relasi organisasi dan jabatannya dengan pagination
        $myOrganizations = $request->user()->userOrganizations()
            ->with(['organization', 'role', 'division'])
            ->paginate(15);

        return response()->json($myOrganizations);
    }

    // Membuat room organisasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organizations_cash' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:255',
            'password_organizations' => 'required|string|min:4|max:255',
        ]);

        DB::beginTransaction();

        try {
            // 1. Pastikan role 'admin' untuk level organisasi sudah ada di database
            // Jika belum ada, otomatis buatkan master perannya
            $adminRole = OrganizationRole::firstOrCreate(
                ['name' => 'admin', 'scope' => 'organization']
            );

            // 2. Buat Organisasinya
            $organization = Organization::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'contact' => $validated['contact'] ?? null,
                'organizations_cash' => $validated['organizations_cash'] ?? null,
                'owner_id' => $request->user()->id,
                'password_organizations' => bcrypt($validated['password_organizations']),
            ]);

            // 3. Hubungkan User yang membuat dengan Organisasi baru sebagai 'admin'
            UserOrganization::create([
                'user_id' => $request->user()->id,
                'organization_id' => $organization->id,
                'role_id' => $adminRole->id,
                'division_id' => null, // null berarti dia admin secara keseluruhan (organisasi)
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Room Organisasi berhasil dibuat',
                'data' => $organization
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat organisasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(
    Organization $organization
    )
    {
        /**
         * Ambil seluruh division
         */
        $divisions = Division::where(
            'organization_id',
            $organization->id
        )->get();

        /**
         * Hapus permission role division
         */
        foreach ($divisions as $division) {

            $divisionRoles = OrganizationRole::where(
                    'division_id',
                    $division->id
                )
                ->get();

            foreach ($divisionRoles as $role) {

                $role->permissions()->detach();

            }

        }

        /**
         * Hapus permission role organization
         */
        $organizationRoles = OrganizationRole::where(
            'organization_id',
            $organization->id
        )->get();

        foreach ($organizationRoles as $role) {

            $role->permissions()->detach();

        }

        /**
         * Hapus seluruh member
         * organization + division
         */
        UserOrganization::where(
            'organization_id',
            $organization->id
        )->delete();

        /**
         * Hapus seluruh role
         */
        OrganizationRole::where(
            'organization_id',
            $organization->id
        )->delete();

        /**
         * Hapus seluruh division
         */
        Division::where(
            'organization_id',
            $organization->id
        )->delete();

        /**
         * Hapus seluruh transaksi
         */
        Transaction::where(
            'organization_id',
            $organization->id
        )->delete();

        /**
         * Hapus organization
         */
        $organization->delete();

        /**
         * Redirect
         */
        return redirect()
            ->route('organizations.index')
            ->with(
                'success',
                'Organisasi berhasil dihapus.'
            );
    }
}
