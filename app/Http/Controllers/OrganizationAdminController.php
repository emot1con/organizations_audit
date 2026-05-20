<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationAdminController extends Controller
{

    /**
     * Admin organizations list
     */
    public function adminIndex()
    {
        $organizations = Organization::latest()
        ->withCount([
            'userOrganizations as total_members' => function ($query) {

                $query->select(DB::raw('count(distinct user_id)'));

            }
        ])
        ->get();

        return view(
            'pages.admin.organizations.index',
            compact('organizations')
        );
    }


    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil dihapus');
    }
}
