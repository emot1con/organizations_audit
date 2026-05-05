<?php

namespace App\Http\Controllers;

use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Mengundang/Menambahkan Anggota
    public function store(Request $request, $organization_id)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|in:admin,bendahara,ketua_divisi,anggota',
            'scope' => 'required|in:organization,division',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        // Cek Admin
        $isAdmin = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)
            ->whereHas('role', function($q) {
                $q->where('name', 'admin')->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        if (!$isAdmin) {
            return response()->json(['message' => 'Hanya Admin Organisasi yang berhak melakukan ini'], 403);
        }

        $targetUser = User::where('email', $request->email)->first();

        // 🛑 Mencegah duplikasi (Anggota sudah ada di organisasi/divisi ini)
        $isAlreadyMember = UserOrganization::where('user_id', $targetUser->id)
            ->where('organization_id', $organization_id)
            ->where('division_id', $request->division_id)
            ->exists();

        if ($isAlreadyMember) {
            return response()->json(['message' => 'Pengguna ini sudah terdaftar sebagai anggota di sini dan tidak bisa dimasukkan lagi.'], 400);
        }

        $role = OrganizationRole::firstOrCreate([
            'name' => $request->role,
            'scope' => $request->scope
        ]);

        $member = UserOrganization::create([
            'user_id' => $targetUser->id,
            'organization_id' => $organization_id,
            'division_id' => $request->division_id,
            'role_id' => $role->id
        ]);

        return response()->json([
            'message' => "Berhasil menugaskan {$request->role} ke pengguna",
            'data' => $member->load('role', 'division')
        ], 201);
    }

    // Mengedit Peran (Role) Anggota yang sudah ada
    public function update(Request $request, $organization_id, $member_id)
    {
        $request->validate([
            'role' => 'required|string|in:admin,bendahara,ketua_divisi,anggota',
            'scope' => 'required|in:organization,division'
        ]);

        // Cek Admin
        $isAdmin = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)
            ->whereHas('role', function($q) {
                $q->where('name', 'admin')->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        if (!$isAdmin) return response()->json(['message' => 'Hanya Admin yang dapat mengedit role'], 403);

        $member = UserOrganization::where('organization_id', $organization_id)
            ->where('id', $member_id)
            ->firstOrFail();

        $role = OrganizationRole::firstOrCreate([
            'name' => $request->role,
            'scope' => $request->scope
        ]);

        $member->update(['role_id' => $role->id]);

        return response()->json([
            'message' => 'Jabatan anggota berhasil diubah', 
            'data' => $member->load('role')
        ]);
    }

    // Meng-kick (Menghapus) Anggota dari organisasi/divisi
    public function destroy(Request $request, $organization_id, $member_id)
    {
        // Cek Admin
        $isAdmin = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)
            ->whereHas('role', function($q) {
                $q->where('name', 'admin')->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        if (!$isAdmin) return response()->json(['message' => 'Hanya Admin yang dapat mengeluarkan anggota'], 403);

        $member = UserOrganization::where('organization_id', $organization_id)
            ->where('id', $member_id)
            ->firstOrFail();

        // Keamanan: Admin tidak bisa meng-kick (menghapus akses admin) dirinya sendiri 
        // untuk mencegah organisasi tidak memiliki pemilik
        if ($member->user_id === $request->user()->id && $member->division_id === null) {
            return response()->json(['message' => 'Anda tidak bisa mengeluarkan diri sendiri dari posisi Admin Utama'], 400);
        }

        $member->delete();

        return response()->json(['message' => 'Anggota berhasil dikeluarkan dari organisasi/divisi.']);
    }
}
