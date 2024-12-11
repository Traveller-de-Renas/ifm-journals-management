<?php

namespace App\Livewire\Backend;

use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\ArticleStatus;

class Articles extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $article;
    public $deleteModal = false;
    public $confirmModal = false;
    public $modal_title;
    public $action;

    public $record;
    public $volume;
    public $issue;
    public $status;
    
    public function mount(Request $request){

        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->record = Journal::where('uuid', $request->journal)->first();
        if(empty($this->record)){
            abort(404);
        }

        $article_states = ArticleStatus::all()->pluck('code')->toArray();

        if($request->status != '' && in_array($request->status, $article_states)){
            $this->status = ArticleStatus::where('code', $request->status)->first();
        }
    }
    
    public function render()
    {
        // if($this->record->user_id != auth()->user()->id && !auth()->user()->hasRole('Administrator')){
        //     $articles = Article::where('journal_id', $this->record->id)->where('user_id', auth()->user()->id)->orWhereHas('coauthors', function ($query) {
        //         $query->where('user_id', auth()->user()->id);
        //     })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // }else{
        //     $articles = Article::where('journal_id', $this->record->id)->where(
        //         function ($query) {
        //             if(){
        //                 $query->where('status', '<>', 'Pending');
        //             }
        //         }
        //     )->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // }

        $statuses = ArticleStatus::all();

        $articles = Article::when($this->status, function($query){
            
            $query->where('article_status_id', $this->status->id);

            if(($this->status->code == '002') && $this->record->editors->contains(auth()->user()->id) && $this->record->chief_editor->id != auth()->user()->id){
                $query->whereHas('editors', function($query){
                    $query->where('user_id', auth()->user()->id);
                });
            }

            return $query;
        })->where('journal_id', $this->record->id)->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $articles = $articles->paginate(20);

        return view('livewire.backend.articles', compact('articles', 'statuses'));
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


    public function confirm(Article $article, $title, $action)
    {
        $this->article      = $article;
        $this->modal_title  = $title;
        $this->action       = $action;

        $this->confirmModal = true;
    }

    public function confirmAction()
    {
        $action = $this->action;
        
        $this->$action();
        $this->confirmModal = false;
    }


    public function cancelSubmission()
    {
        $status = $this->articleStatus('012');

        $this->article->update([
            "article_status_id" => $status->id
        ]);

        session()->flash('success', 'Submission Cancelled...!');
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }
}
