<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Admin extends Component
{
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.auth.admin');
    }

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();

            return redirect()->intended('/dashboard');
        }

        return back()->with([
            'message' => 'The provided credentials do not match our records.',
        ]);
    }
}
