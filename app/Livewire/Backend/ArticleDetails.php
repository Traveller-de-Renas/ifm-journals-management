<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleMovementLog;
use App\Models\Issue;
use App\Models\Volume;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleDetails extends Component
{
    public $record;
    public $reviewers = [];
    public $reviewer_id;
    public $description;

    public $reviewerModal = false;
    public $declineModal = false;
    public $sendModal = false;

    public $volume;
    public $issue;
    public $volumes = [];
    public $issues  = [];
    
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
        $volume_all    = $this->record->journal->volumes;
        $this->volumes = $volume_all->pluck('description', 'id')->toArray();
        $this->issues  = Issue::where('volume_id', $this->volume)->get()->pluck('description', 'id')->toArray();
        return view('livewire.backend.article-details');
    }


    public function assignReviewer()
    {
        $this->reviewerModal = true;
    }

    public function declineArticle()
    {
        $this->dispatch('contentChanged');
        $this->declineModal = true;
    }

    public function sendBack()
    {
        $this->dispatch('contentChanged');
        $this->sendModal = true;
    }

    public function assignRev()
    {
        $this->record->article_users()->sync([$this->reviewer_id => ['role' => 'reviewer']], false);
        
        session()->flash('success', 'Reviewer is Assigned successfully');
        $this->reviewerModal = false;
    }

    public function decline()
    {
        $mlog = ArticleMovementLog::create([
            'article_id' => $this->record->id,
            'user_id' => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->status = 'Declined';
        $this->record->save();
        session()->flash('success', 'This Article is Declined');

        $this->reset(['description']);

        $this->declineModal = false;
    }

    public function send_back()
    {
        $mlog = ArticleMovementLog::create([
            'article_id' => $this->record->id,
            'user_id' => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->status = 'From Editor';
        $this->record->save();
        session()->flash('success', 'This Article is Declined');

        $this->reset(['description']);

        $this->declineModal = false;
    }

    public function updateVolume()
    {
        //$this->record->volume_id = $this->volume;
        $this->record->issue_id  = $this->issue;
        $this->record->save();

        session()->flash('success', 'Volume and Issue Updated Successfully!');
    }


    public function changeStatus($status)
    {
        //dd($this->record);
        $this->record->status = $status;
        $this->record->update();
        session()->flash('success', 'Article Successifully '.$status.'ed');
    }
}
