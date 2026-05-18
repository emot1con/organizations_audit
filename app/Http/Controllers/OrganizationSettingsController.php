<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationSettingsController extends Controller
{
    public function index(Organization $organization)
    {
        $organization->load([

            'roles' => function ($query) {

                $query->where(
                    'scope',
                    'organization'
                );

            }

        ]);

        return view(
            'pages.settings.organizations.index',
            compact('organization')
        );
    }


     public function show(Organization $organization)
    {
        $organization->load([

            'roles' => function ($query) {

                $query
                    ->where('scope', 'organization')
                    ->whereNull('division_id')
                    ->withCount('userOrganizations')
                    ->orderBy('user_organizations_count');

            }

        ]);

        return view(
            'pages.settings.organizations.show',
            compact('organization')
        );
    }
}