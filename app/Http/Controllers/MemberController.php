<?php

namespace App\Http\Controllers;

use App\Models\OrganizationRole;
use App\Models\UserOrganization;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Mengundang/Menambahkan Anggota dan Mengatur Role (Fitur 4 & 5)
    public function store(Request $request, $organization_id)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|string|in:admin,bendahara,ketua_divisi,anggota',
            'scope' => 'required|in:organization,division',
            'division_id' => 'nullable|exists:divisions,id'
        ]);

        // Cek Otorisasi (Hanya Admin Organisasi yang bisa invite/ubah role global)
        // Note: Nanti bisa diextend agar ketua divisi bisa invite anggota ke divisinya saja
        $isAdmin = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)
            ->whereHas('role', function($q) {
                $q->where('name', 'admin')->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        if (<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\UserOrganization;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    // Melihat daftar divisi dalam suatu organisasi (Fitur 6 - Anggota bisa lihat)
    public function index(Request $request, $organization_id)
    {
        // Pastikan user adalah anggota organisasi ini (bisa admin, anggota, dll)
        $isMember = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)->exists();

        if (MemberControllerisMember) return response()->json(['message' => 'Unauthorized'], 403);

        $divisions = Division::where('organization_id', $organization_id)->get();
        
        return response()->json(['data' => $divisions]);
    }

    // Membuat Room Divisi (Fitur 3)
    public function store(Request $request, $organization_id)
    {
        $request->validate([
            'name' => 'required|string', 
            'category' => 'nullable|string'
        ]);

        // Cek Otorisasi: Harus Admin Organisasi (Fitur 4 & 5 - Keamanan)
        $isAdmin = UserOrganization::where('user_id', $request->user()->id)
            ->where('organization_id', $organization_id)
            ->whereHas('role', function($q) {
                $q->where('name', 'admin')->where('scope', 'organization');
            })
            ->whereNull('division_id')
            ->exists();

        if (MemberControllerisAdmin) {
            return response()->json(['message' => 'Hanya Admin Organisasi yang dapat membuat divisi'], 403);
        }

        $division = Division::create([
            'organization_id' => $organization_id,
            'name' => $request->name,
            'category' => $request->category,
        ]);

        return response()->json([
            'message' => 'Divisi berhasil ditambahkan', 
            'data' => $division
        ], 201);
    }
}
EOFisAdmin) {
            return response()->json(['message' => 'Hanya Admin Organisasi yang berhak melakukan ini'], 403);
        }

        $targetUser = User::where('email', $request->email)->first();

        // Cari atau Buat Role berdasarkan input
        $role = OrganizationRole::firstOrCreate([
            'name' => $request->role,
            'scope' => $request->scope
        ]);

        // Tambahkan ke Pivot Table (atau update rolenya jika sudah ada)
        $member = UserOrganization::updateOrCreate([
            'user_id' => $targetUser->id,
            'organization_id' => $organization_id,
            'division_id' => $request->division_id,
        ], [
            'role_id' => $role->id
        ]);

        return response()->json([
            'message' => "Berhasil menugaskan role {$request->role} ke pengguna",
            'data' => $member->load('role', 'division')
        ], 201);
    }
}
