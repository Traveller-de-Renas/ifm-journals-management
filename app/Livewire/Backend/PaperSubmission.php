<?php

namespace App\Livewire\Backend;

use App\Models\Article;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PaperSubmission extends Component
{
    public $record;

    public $title;
    public $abstract;
    public $country_id;
    public $issue_id;
    public $Keywords;

    public $issues = [];
    public $countries = [];

    public function mount(Request $request)
    {
        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->record = Journal::where('uuid', $request->journal)->first();
        if(empty($this->record)){
            abort(404);
        }

        $this->countries = Country::all()->pluck('name', 'id')->toArray();
    }
    
    public function render()
    {
        return view('livewire.backend.paper-submission');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'abstract' => 'required',
        ]);

        $article = Article::create([
            'title' => $this->title,
            'abstract' => $this->abstract,
            'country_id' => $this->country_id,
            'journal_id' => $this->record->id,
            'keywords' => $this->Keywords,
            'status' => 'Submitted',
        ]);
        
    }

    public $step = 1;

    public function incrementStep()
    {
        $this->step++;
    }

    public function decrementStep()
    {
        $this->step--;
    }

}
