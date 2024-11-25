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

class Volumes extends Component
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
    public $viewhide = 0;
    
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
        // if($this->record->user_id != auth()->user()->id){
        //     $articles = Article::where('journal_id', $this->record->id)->where('user_id', auth()->user()->id)->orWhereHas('coauthors', function ($query) {
        //         $query->where('user_id', auth()->user()->id);
        //     })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // }else{
        //     $articles = Article::where('journal_id', $this->record->id)->where('status', 'Submitted')->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        // }

        $statuses = ArticleStatus::all();

        $this->issue  =  (Issue::max('number') != '')? Issue::where('number', Issue::max('number'))->first() : 'None' ;
        $this->volume =  (Volume::max('number') != '')? Volume::where('number', Volume::max('number'))->first() : 'None' ;

        return view('livewire.backend.volumes', compact('statuses'));
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


    public function createVolume()
    {
        $max_volume = (Volume::max('number') != '')? Volume::max('number') : 0 ;

        //dd($max_volume);
        $new_volume = $max_volume + 1;

        $volume = new Volume;

        $volume->number      = $new_volume;
        $volume->description = 'volume '.$new_volume;
        $volume->journal_id  = $this->record->id;

        if($volume->save()){
            session()->flash('success', 'New Volume has been created successfully!');
        }
    }

    public function createIssue()
    {
        if($this->volume == 'None'){
            session()->flash('danger', 'No Volume has been created!');
        }else{
            $max_issue = (Issue::max('number') != '')? Issue::max('number') : 0 ;

            //dd($max_issue);
            $new_issue = $max_issue + 1;

            $volume = new Issue;

            $volume->number      = $new_issue;
            $volume->description = 'volume '.$new_issue;
            $volume->volume_id   = $this->volume;
            $volume->journal_id  = $this->record->id;

            if($volume->save()){
                session()->flash('success', 'New Issue has been created successfully!');
            }
        }
        
    }

    public function expand($key)
    {
        $this->viewhide = $key;
    }

    public function publishIssue(Issue $issue, $status)
    {
        $issue->status = $status;

        if($issue->save()){
            $issue->articles()->update(['status' => $status]);
            session()->flash('success', 'Issue has been published successfully!');
        }
        
    }
}
