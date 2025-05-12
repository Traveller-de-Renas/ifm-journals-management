<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.users');
    }

    public function logs()
    {
        return view('backend.user_logs');
    }

    public function salutations()
    {
        return view('backend.salutations');
    }

    public function roles()
    {
        return view('backend.roles');
    }

    public function permissions()
    {
        return view('backend.permissions');
    }

    public function user_profile()
    {
        return view('backend.user_profile');
    }

    //failed jobs
    public function failed_jobs()
    {
        return view('backend.failed_jobs');
    }
}
