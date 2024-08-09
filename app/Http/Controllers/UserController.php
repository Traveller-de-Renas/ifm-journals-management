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
        return view('backend.logs');
    }
}
