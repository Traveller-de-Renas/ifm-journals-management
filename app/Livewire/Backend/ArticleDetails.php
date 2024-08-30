<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleDetails extends Component
{
    public $record;
    public $reviewers = [];
    public $reviewer_id;
    public $reviewerModal = false;
    
    public function mount(Request $request){

        if(!Str::isUuid($request->article)){
            abort(404);
        }
        
        $this->record = Article::where('uuid', $request->article)->first();
        if(empty($this->record)){
            abort(404);
        }

        $this->reviewers = User::all();
    }
    
    public function render()
    {
        return view('livewire.backend.article-details');
    }


    public function assignReviewer()
    {
        $this->reviewerModal = true;
    }

    public function assignRev()
    {
        $this->record->article_users()->sync([$this->reviewer_id => ['role' => 'reviewer']], false);
        
        session()->flash('success', 'Reviewer is Assigned successfully');
        $this->reviewerModal = false;
    }
}
