<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    // Mengambil daftar organisasi milik user yang sedang login
    public function index(Request $request)
    {
        // Mengambil data relasi organisasi dan jabatannya
        $myOrganizations = $request->user()->userOrganizations()
            ->with(['organization', 'role', 'division'])
            ->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar organisasi',
            'data' => $myOrganizations
        ]);
    }

    // Membuat room organisasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact' => 'nullable|string|max:255',
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
}
