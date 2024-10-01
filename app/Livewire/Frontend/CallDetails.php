<?php

namespace App\Livewire\Frontend;

use App\Models\CallForPaper;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CallDetails extends Component
{
    public $record;

    public function mount(Request $request){

        if(!Str::isUuid($request->call)){
            abort(404);
        }
        
        $this->record = CallForPaper::where('uuid', $request->call)->first();
        if(empty($this->record)){
            abort(404);
        }
    }
    
    public function render()
    {
        return view('livewire.frontend.call-details');
    }
}
