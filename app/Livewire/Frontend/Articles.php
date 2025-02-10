<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Issue;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $article;

    public $record;
    public $volume;
    public $journal;
    
    public function mount(Request $request)
    {
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
        $articles = Article::where('issue_id', $this->record->id)->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        $articles = $articles->paginate(20);

        return view('livewire.frontend.articles', compact('articles'));
    }

}
