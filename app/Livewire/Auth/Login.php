<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;
    public $journal;

    public function mount(Request $request){
        if($request->path() != 'admin'){
            if(!Str::isUuid($request->journal)){
                abort(404);
            }
            
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

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            // dd($user->journal_users()->pluck('journals.id')->toArray());
            // dd(in_array($this->journal->id, $user->journal_users()->pluck('journals.id')->toArray()));
            // dd($user->journal_users()->where('journal_id', $this->journal->id)->exists());

            if($user->hasRole('Administrator')){
                return redirect()->intended('/dashboard');
            }else{
                if(!$user->journal_users()->where('journal_id', $this->journal->id)->exists()){
                    Auth::logout();

                    return back()->with([
                        'message' => 'It seems you are not registered to this journal please register to proceed.',
                    ]);
                }

                $user->update([
                    'journal' => $this->journal->uuid
                ]);
                
                return redirect()->intended('/journals/details/'.$this->journal->uuid);
            }
        }

        return back()->with([
            'message' => 'The provided credentials do not match our records.',
        ]);
    }
}
