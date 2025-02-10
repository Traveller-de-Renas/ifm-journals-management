<?php

namespace App\Livewire\Frontend;

use App\Models\Issue;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Editorial extends Component
{
    public $record;
    public $reviewers = [];
    public $reviewer_id;
    public $reviewerModal = false;
    
    public function mount(Request $request){

        if(!Str::isUuid($request->issue)){
            abort(404);
        }
        
        $this->record = Issue::where('uuid', $request->issue)->first();
        if(empty($this->record)){
            abort(404);
        }
    }
    
    public function render()
    {
        return view('livewire.frontend.editorial');
    }
}
