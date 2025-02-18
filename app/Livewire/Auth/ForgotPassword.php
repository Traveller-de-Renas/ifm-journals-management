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
            session()->flash('success', 'A password reset link was successfully sent to your email address. Please check your inbox and follow the instructions.');

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
        }else{
            session()->flash('error_message', 'No user records found registered with this email');
        }

    }

}
