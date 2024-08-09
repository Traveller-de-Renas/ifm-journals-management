<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function roles()
    {
        return view('backend.roles');
    }

    public function permissions()
    {
        return view('backend.permissions');
    }

    public function salutations()
    {
        return view('backend.salutations');
    }
}
