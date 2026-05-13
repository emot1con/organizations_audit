<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $organizations = $request->user()
            ->userOrganizations()
            ->with([
                'organization.userOrganizations'
            ])
            ->latest()
            ->take(6)
            ->get();

        return view('pages.dashboard', [
            'organizations' => $organizations
        ]);
    }
}