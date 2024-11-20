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


    public function createVolume()
    {
        $max_volume = (Volume::max('number') != '')? Volume::max('number') : 0 ;

        $new_volume = $max_volume + 1;

        $volume = new Volume;

        $volume->number      = $new_volume;
        $volume->description = 'volume '.$new_volume;
        $volume->journal_id  = $this->record->id;

        if($volume->save()){
            $this->record->volume_id = $volume->id;
            $this->record->save();

            session()->flash('success', 'New Volume has been created successfully!');
        }
    }

    public function createIssue()
    {
        if($this->record->volume_id == ''){
            session()->flash('danger', 'No Volume has been created!');
        }else{
            $max_issue = (Issue::max('number') != '')? Issue::max('number') : 0 ;

            $new_issue = $max_issue + 1;

            $issue = new Issue;

            $issue->number      = $new_issue;
            $issue->description = 'Issue '.$new_issue;
            $issue->volume_id   = $this->record->volume_id;
            $issue->journal_id  = $this->record->id;
            $issue->status      = 'Pending';

            if($issue->save()){
                $this->record->issue_id = $issue->id;
                $this->record->save();

                session()->flash('success', 'New Issue has been created successfully!');
            }
        }
    }

    public function publishIssue(Issue $issue)
    {
        $issue->status = 'Published';

        $state = $this->articleStatus('006');

        if($issue->save()){
            $issue->articles()->update(['article_status_id' => $state->id]);
            session()->flash('success', 'Issue has been published successfully!');
        }
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }
}
