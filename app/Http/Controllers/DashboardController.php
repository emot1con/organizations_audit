<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Organization;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $organizations = Organization::whereHas(
        'userOrganizations',
        function ($query) {

            $query->where(
                'user_id',
                Auth::id()
            );

        }
    )
    ->with([

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
    ->get();

        return view('pages.dashboard', [

            'organizations' => $organizations,

        ]);
    }
}