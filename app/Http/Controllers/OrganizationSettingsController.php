<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationSettingsController extends Controller
{
     public function index(Organization $organization)
    {
        return view(
            'pages.settings.organizations.index',
            compact('organization')
        );
    }
}
