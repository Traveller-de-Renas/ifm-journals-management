<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleStatus;
use App\Models\ReviewSection;
use App\Models\ArticleMovementLog;

class ArticleEvaluation extends Component
{
    public $record;
    public $reviewer;
    public $selectedOption = [];
    public $commentWritten = [];

    public $description;
    
    public $declineModal = false;
    
    public function mount(Request $request){

        if(!Str::isUuid($request->article)){
            abort(404);
        }

        if(!Str::isUuid($request->reviewer)){
            abort(404);
        }
        
        $this->record = Article::where('uuid', $request->article)->first();
        if(empty($this->record)){
            abort(404);
        }

        $this->reviewer = User::where('uuid', $request->reviewer)->first();
        if(empty($this->reviewer)){
            abort(404);
        }
    }
    
    public function render()
    {
        $editor = $this->record->journal->journal_users()->where('role', 'editor')->first();
        $submission = $this->record->files()->first();
        $sections = ReviewSection::all();

        return view('livewire.backend.article-evaluation', compact('editor', 'submission', 'sections'));
    }

    public function upOptions($key, $value)
    {
        // Handle logic after a selection is updated
        $this->selectedOption[$key] = $value;
    }

    public function store()
    {
        //article_id
        //review_section_id
        //review_section_query_id
        //review_section_option_id
        //value

        

        dd($this->commentWritten, $this->selectedOption);
    }

    public function declineArticle()
    {
        $this->dispatch('contentChanged');
        $this->declineModal = true;
    }

    public function decline()
    {
        $mlog = ArticleMovementLog::create([
            'article_id' => $this->record->id,
            'user_id' => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->article_status_id = $this->articleStatus('008')->id;
        $this->record->save();
        session()->flash('success', 'This Article is Declined');

        $this->reset(['description']);

        $this->declineModal = false;
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }
}
