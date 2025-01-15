<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
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

    public function profile()
    {
        return view('backend.profile');
    }

    public function user_preview()
    {
        return view('backend.user_preview');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function admin()
    {
        return view('auth.admin');
    }

    public function destroy(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if(Str::isUuid(auth()->user()->journal)){
            $url = route('journal.detail', auth()->user()->journal);
        }else{
            $url = '/';
        }
        return redirect($url);
    }
}
