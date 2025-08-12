<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordChangeRequest;

class ResetPassword extends Component
{
    public $user;
    public $password;
    public $password_confirmation;
    public $prequest;
    
    public function mount(){
        if(!Str::isUuid(request('user'))){
            abort(404);
        }

        $user_uid = strip_tags(request('user'));
        $this->prequest = PasswordChangeRequest::where('uuid', $user_uid)->first();

        if(empty($this->prequest)){
            abort(404);
        }

        $start = Carbon::parse($this->prequest->updated_at);
        $end   = Carbon::parse(now());

        $diff  = $start->diffInMinutes($end);

        if($diff > 15){
            $this->prequest->update([
                'status' => 0
            ]);
        }


    }


    public function render()
    {
        return view('livewire.auth.reset-password');
    }

    public function resetPassword()
    {
        // $this->validate(['password' => 'string|required|confirmed|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/']);
        $this->validate(['password' => 'string|required|confirmed|min:8|regex:/^(?=\S{8,})(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).*$/']);
        
        
        if($this->prequest->user->update([
            'password' => Hash::make($this->password)
        ])){
            session()->flash('success', 'You are successfully updated your login password. You can now login to proceed to the submission portal.');
        }else{
            session()->flash('error_message', 'Failed to update your password');
        }
    }
}
