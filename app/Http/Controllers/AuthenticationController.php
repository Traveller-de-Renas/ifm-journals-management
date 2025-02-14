<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function login()
    {
        if(session()->has('journal')){
            return view('auth.login');
        }else{
            return view('frontend.home');
        }
        
    }

    public function admin()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        $route = '/';
        if(session()->has('journal')){
            $route = 'journal/detail/'. session()->get('journal');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($route);
    }


    public function accountActivation()
    {
        dd('Activate Account');
    }

}
