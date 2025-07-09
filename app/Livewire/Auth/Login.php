<?php

namespace App\Livewire\Auth;

use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;

class Login extends Component
{
    public $journal;
    
    public function mount(Request $request)
    {
        if(Str::isUuid($request->journal)){
            $this->journal = Journal::where('uuid', $request->journal)->first();
            if(empty($this->journal)){
                abort(404);
            }
        }

    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    public $email;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $key = Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            event(new Lockout(request()));

            $seconds = RateLimiter::availableIn($key);
            session()->flash('error_message', "Too many login attempts. Please try again in {$seconds} seconds.");
            return;
        }

        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key); // Clear attempts after success

            session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('Administrator')) {
                return redirect(route('journals.dashboard'));
            } else {
                if ($this->journal) {
                    session(['journal' => $this->journal->uuid]);

                    if (!$user->journal_us()->where('journal_id', $this->journal->id)->where('status', 1)->exists()) {
                        Auth::logout();
                        session()->flash('error_message', 'It seems you are not registered to this journal. Please register or activate your account to proceed.');
                        return redirect()->route('login', ['journal' => $this->journal->uuid]);
                    }

                    return redirect(route('journals.articles', ['journal' => $this->journal->uuid, 'status' => 'with_decisions']));
                } else {
                    session()->flash('error_message', 'It seems you have not selected a journal to login.');
                }
            }
        }

        RateLimiter::hit($key, 1800); // Add failed attempt, 60 seconds decay
        session()->flash('error_message', 'The provided credentials do not match our records.');
    }
}
