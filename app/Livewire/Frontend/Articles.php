<?php

namespace App\Livewire\Frontend;

use App\Models\Article;
use App\Models\Journal;
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
    public $deleteModal = false;

    public $record;
    public $volume;
    public $issue;
    
    public function mount(Request $request){

        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->record = Journal::where('uuid', $request->journal)->first();
        if(empty($this->record)){
            abort(404);
        }
    }
    
    public function render()
    {
        
        $articles = Article::where('journal_id', $this->record->id)->where('status', 'Published')->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        $articles = $articles->paginate(20);

        return view('livewire.frontend.articles', compact('articles'));
        
    }

    public function delete(Article $article)
    {
        $article->files()->delete();
        $article->submission_confirmations()->delete();
        $article->delete();

        $this->deleteModal = false;
    }

    public function confirmDelete(Article $article)
    {
        $this->article = $article;
        $this->deleteModal = true;
    }
}
