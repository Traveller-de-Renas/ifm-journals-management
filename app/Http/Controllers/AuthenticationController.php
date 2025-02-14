<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Journal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function login()
    {
        if(session()->has('journal') || request('journal')){
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
        if(!Str::isUuid(request('journal')) || !Str::isUuid(request('user'))){
            abort(404);
        }

        $user_uid    = strip_tags(request('user'));
        $journal_uid = strip_tags(request('journal'));

        $user    = User::where('uuid', $user_uid)->first();
        $journal = Journal::where('uuid', $journal_uid)->first();

        if(empty($user) || empty($journal)){
            abort(404);
        }


        $journal_user = $user->journal_us()->where('journal_id', $journal->id)->first();
        if(empty($journal_user)){
            abort(404);
        }

        if($journal_user->update(['status' => 1])){

            session()->flash('success', 'Your account is successfully activated. You can now proceed to the submission portal through the login link below');
            return view('auth.account-activation', compact('journal'));
        }else{
            abort(404);
        }

    }
}
