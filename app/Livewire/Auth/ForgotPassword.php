<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Mail\PasswordRequest;
use App\Models\ReviewMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\PasswordChangeRequest;

class ForgotPassword extends Component
{
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }


    public $email;

    public function sendLink()
    {
        $this->validate(['email'=>'required|email']);

        $user = User::where('email', $this->email);

        if($user->exists()){
            session()->flash('success', 'You are successfully registered as new author on this journal to proceed with to the submission portal please activate your account through the link sent to your email address.');

            $prequest = PasswordChangeRequest::firstOrCreate([
                'user_id' => $user->first()->id,
                'status'  => 1
            ],[
                'user_id' => $user->first()->id,
                'journal' => session()->get('journal')
            ]);

            if(ReviewMessage::where('category', 'Password Request')->count() > 0){
                dd($this->email);
                Mail::to($this->email)
                    ->send(new PasswordRequest($user->first(), $prequest));
            }
        }else{
            session()->flash('error_message', 'No user records found registered with this email');
        }

    }

}
