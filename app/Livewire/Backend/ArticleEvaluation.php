<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleReview;
use App\Models\ArticleStatus;
use App\Models\ReviewSection;
use Livewire\WithFileUploads;
use App\Models\ReviewAttachment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ArticleEvaluation extends Component
{
    use WithFileUploads;
    
    public $record;
    public $reviewer;
    public $reviewOption  = [];
    public $reviewComment = [];
    public $review_attachment;
    public $user;
    public $journal_user;

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

        $this->journal_user = $this->reviewer->journal_us()->where('journal_id', $this->record->journal_id)->first();

        $this->reviewOption = ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->pluck('review_section_option_id', 'review_section_query_id')->toArray();

        $this->reviewComment = ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->pluck('comment', 'review_section_query_id')->toArray();
    }
    
    public function render()
    {
        $submission = $this->record->files()->first();
        $sections   = ReviewSection::all();

        return view('livewire.backend.article-evaluation', compact('submission', 'sections'));
    }

    public function upOptions($key, $value)
    {
        $this->reviewOption[$key] = $value;
    }

    public function rules()
    {
        return [
            'reviewComment.*' => 'required'
        ];
    }

    public function store($state)
    {
        $options  = $this->reviewOption;
        $comments = $this->reviewComment;

        ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->delete();

        foreach($options as $key => $value){
            if($value != ''){
                ArticleReview::create([
                    'article_id' => $this->record->id,
                    'review_section_query_id' => $key,
                    'review_section_option_id' => $value,
                    'user_id' => $this->reviewer->id
                ]);
            }
        }

        foreach($comments as $key => $value){
            if($value != ''){
                ArticleReview::create([
                    'article_id' => $this->record->id,
                    'review_section_query_id' => $key,
                    'comment' => $value,
                    'user_id' => $this->reviewer->id
                ]);
            }
        }

        if($this->review_attachment){
            $this->validate([
                'review_attachment.*' => 'mimes:pdf|max:2048'
            ]);
        
            foreach($this->review_attachment as $attachment){
                $_name = $attachment->getClientOriginalName();
                $_type = $attachment->getClientOriginalExtension();
                $_file = str_replace(' ', '_', $_name);
            
                $attachment->storeAs('/review_attachments', $_file);

                ReviewAttachment::create([
                    'article_id' => $this->record->id,
                    'attachment' => $_name,
                    'user_id'    => $this->reviewer->id
                ]);
            }
        }

        if($state == 'complete'){
            $this->description = 'This Article Review is Complete and Submitted Back to the Editor for Further Processes';
            $this->journal_user->article_journal_users()->sync([$this->record->id => [
                'review_status' => 'completed'
            ]], false);

            session()->flash('response',[
                'status'  => 'success',
                'message' => $this->description.', We would like to extend our sinciere thanks for your careful review of our manuscript. Your expert comments have been invaluable in refining the manuscript and ensuring its rigor and clarity.'
            ]);

            // Mail::to('mrenatuskiheka@yahoo.com')
            //     ->send(new ReviewerResponse($this->record, $this->description));
        }else{
            session()->flash('response',[
                'status'  => 'success',
                'message' => 'Article Review is not Completed but Saved so that you can continue to review the Article'
            ]);
        }
    }

    public function declineArticle()
    {
        $this->dispatch('contentChanged');
        $this->declineModal = true;
    }

    public function decline()
    {
        $this->journal_user->article_journal_users()->sync([$this->record->id => [
            'review_status' => 'declined'
        ]], false);

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'This Article is Declined, Thanks we hope next time you will be able to assist us on reviewing relevant manuscript'
        ]);

        // Mail::to('mrenatuskiheka@yahoo.com')
        //     ->send(new ReviewerResponse($this->record, $this->description));

        $this->reset(['description']);
        $this->declineModal = false;
    }

    public function accept()
    {
        $this->journal_user->article_journal_users()->sync([$this->record->id => [
            'review_status' => 'accepted'
        ]], false);

        // Mail::to('mrenatuskiheka@yahoo.com')
        //     ->send(new ReviewerResponse($this->record, $this->description));
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }

    public function removeAttachment(ReviewAttachment $attachment)
    {
        if(file_exists(storage_path('app/public/review_attachments/'.$attachment->attachment))){
            Storage::delete('public/review_attachments/'.$attachment->attachment);
            if($attachment->delete()){
                session()->flash('success', 'Attachment Deleted Successfully');
            }
        }
    
    }
}
