<?php

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

        if (!$isMember) return response()->json(['message' => 'Unauthorized'], 403);

        // Menambahkan pagination (15 item per halaman)
        $divisions = Division::where('organization_id', $organization_id)->paginate(15);
        
        return response()->json($divisions);
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

        if (!$isAdmin) {
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
