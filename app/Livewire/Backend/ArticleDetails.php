<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use Livewire\Component;
use App\Mail\EditorMail;
use App\Mail\ReviewerMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleReview;
use App\Models\ArticleStatus;
use App\Models\ReviewSection;
use App\Models\ArticleMovementLog;
use Illuminate\Support\Facades\Mail;

class ArticleDetails extends Component
{
    public $record;
    public $reviewers = [];
    public $reviewer_id;
    public $description;

    public $reviewerModal = false;
    public $declineModal = false;
    public $sendModal = false;
    public $assignModal = false;
    public $editorFeedback = false;
    public $reviewerFeedback = false;

    public $sections;
    public $reviewOption  = [];
    public $reviewComment = [];
    public $review_attachment;

    public $users;
    public $role;

    public $volume;
    public $issue;
    public $volumes = [];
    public $issues  = [];

    public $user_id;
    
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

        $statuses = ArticleStatus::all();

        return view('livewire.backend.article-details', compact('statuses'));
    }

    public function assignReviewer()
    {
        $this->reviewerModal = true;
    }

    public function assignEditor()
    {
        // $this->reviewers = User::all();
        // $chief = $this->record->journal->chief_editor)->first()->id;

        $this->users = $this->record->journal->editors;
        $this->role = 'editor';
        $this->assignModal = true;
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

        //Mail::to('mrenatuskiheka@yahoo.com')->send(new ReviewerMail($this->record));
        Mail::to('mandariherman@gmail.com')
            ->cc('mrenatuskiheka@yahoo.com')
            ->send(new ReviewerMail($this->record));
        
        session()->flash('success', 'Reviewer is Assigned successfully');
        $this->reviewerModal = false;
    }

    public function eFeedback()
    {
        $this->dispatch('contentChanged');
        $this->editorFeedback = true;
    }

    public function reviewFeedback(User $reviewer)
    {
        $this->reviewOption = ArticleReview::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('review_section_option_id', 'review_section_query_id')->toArray();

        $this->reviewComment = ArticleReview::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('comment', 'review_section_query_id')->toArray();
        $this->sections = ReviewSection::all();
        $this->reviewerFeedback = true;
    }

    public function attachUser()
    {
        $this->record->article_users()->sync([$this->user_id => ['role' => $this->role]], false);

        Mail::to('mrenatuskiheka@yahoo.com')
            ->send(new EditorMail($this->record));
        
        session()->flash('success', 'Assigned successfully to this Article');
        $this->assignModal = false;
    }

    public function decline()
    {
        $mlog = ArticleMovementLog::create([
            'article_id' => $this->record->id,
            'user_id' => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->article_status_id = $this->articleStatus('007')->id;
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

        $this->record->article_status_id = $this->articleStatus('013')->id;
        $this->record->save();
        session()->flash('success', 'Done!');

        $this->reset(['description']);

        $this->declineModal = false;
    }

    public function toChiefEditor()
    {
        $mlog = ArticleMovementLog::create([
            'article_id' => $this->record->id,
            'user_id' => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->article_status_id = $this->articleStatus('003')->id;
        $this->record->save();
        session()->flash('success', 'Successifully Sent to Chief Editor');

        $this->reset(['description']);

        $this->declineModal = false;
    }

    public function updateVolume()
    {
        $this->record->issue_id  = $this->issue;
        $this->record->save();

        session()->flash('success', 'Volume and Issue Updated Successfully!');
    }


    public function changeStatus($status)
    {
        $this->record->article_status_id = $this->articleStatus($status)->id;
        $this->record->update();
        session()->flash('success', 'Article Successifully '.$status.'ed');
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }
}
