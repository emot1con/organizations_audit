<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Organization;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view(
            'pages.dashboard',
            [

                'organizations' =>
                    $organizations,

                /**
                 * Global Stats
                 */
                'totalOrganizations' =>
                    Organization::count(),

                'totalUsers' =>
                    User::count(),

                'totalDivisions' =>
                    Division::count(),

                'todayTransactions' =>
                    Transaction::whereDate(
                        'created_at',
                        today()
                    )->count(),

                /**
                 * User Stats
                 */
                'myOrganizations' =>
                    $organizations->count(),

                'myDivisions' =>
                    \App\Models\UserOrganization::where(
                        'user_id',
                        Auth::id()
                    )
                    ->whereNotNull(
                        'division_id'
                    )
                    ->count(),

                'myTransactions' =>
                    Transaction::where(
                        'created_by',
                        Auth::id()
                    )->count(),

            ]
        );
    }
}