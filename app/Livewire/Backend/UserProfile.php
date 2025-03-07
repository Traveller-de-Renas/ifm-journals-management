<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserProfile extends Component
{
    public $record;
    
    public function mount(Request $request){
        if(!Str::isUuid($request->user)){
            abort(404);
        }

        $this->record = User::where('uuid', $request->user)->first();
        if(empty($this->record)){
            abort(404);
        }
    }

    public function render()
    {
        
        return view('livewire.backend.user-profile');
    }
}
