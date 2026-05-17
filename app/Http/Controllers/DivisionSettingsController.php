<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionSettingsController extends Controller
{
    public function index(Division $division)
    {
        return view(
            'pages.settings.divisions.index',
            compact('division')
        );
    }
}
