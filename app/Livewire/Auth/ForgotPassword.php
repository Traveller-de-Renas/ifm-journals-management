<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\PasswordRequest;
use App\Models\ReviewMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordChangeRequest;

class ForgotPassword extends Component
{
    public $journal;

    public function mount()
    {
        if(Str::isUuid(request()->journal)){
            $this->journal = Journal::where('uuid', request()->journal)->first();
        }
    }
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }


    public $email;

    public function sendLink()
    {
        $this->validate(['email'=>'required|email']);

        $user = User::where('email', $this->email);

        if ($user->hasRole('Administrator')) {
            $this->createRequest($user);
        } else {

            if(!$user->first()->journal_us()->where('journal_id', $this->journal->id)->where('status', 1)->exists()){
                session()->flash('error_message', 'It seems you are not registered to this journal please register, or activate your account.');

                return redirect()->route('password_request', ['journal' => $this->journal->uuid]);
            }else{
                if($user->exists()){
                    session()->flash('success', 'A password reset link was successfully sent to your email address. Please check your inbox and follow the instructions.');

                    $this->createRequest($user);
                }
            }

        }

    }


    protected function createRequest($user)
    {
        $prequest = PasswordChangeRequest::firstOrCreate([
            'user_id' => $user->first()->id,
            'status'  => 1
        ],[
            'user_id' => $user->first()->id,
            'journal' => session()->get('journal')
        ]);

        if(ReviewMessage::where('category', 'Password Request')->count() > 0){
            Mail::to($this->email)
                ->send(new PasswordRequest($user->first(), $prequest));
        }
    } 

}
