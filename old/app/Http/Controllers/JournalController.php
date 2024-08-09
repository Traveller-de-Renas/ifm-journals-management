<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        return view('backend.journals');
    }

    public function subjects()
    {
        return view('backend.subjects');
    }

    public function categories()
    {
        return view('backend.categories');
    }
}
