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
use App\Models\ReviewSectionsGroup;
use Illuminate\Support\Facades\Mail;
use App\Models\ReviewSectionsComment;
use Illuminate\Support\Facades\Storage;

class ArticleEvaluation extends Component
{
    use WithFileUploads;

    public $record;
    public $reviewer;
    public $reviewOption   = [];
    public $reviewOptionValue   = [];
    public $reviewComment  = [];
    public $reviewSComment = [];
    public $review_attachment;
    public $review_decision;
    public $user;
    public $journal_user;
    public $article_journal_user;

    public $description;

    public $declineModal = false;

    public $totalOptions = 0;

    public $sections;

    public function mount(Request $request)
    {

        if (!Str::isUuid($request->article)) {
            abort(404);
        }

        if (!Str::isUuid($request->reviewer)) {
            abort(404);
        }

        $this->record = Article::where('uuid', $request->article)->first();
        if (empty($this->record)) {
            abort(404);
        }

        $this->reviewer = User::where('uuid', $request->reviewer)->first();
        if (empty($this->reviewer)) {
            abort(404);
        }

        $this->journal_user = $this->reviewer->journal_us()->where('journal_id', $this->record->journal_id)->first();

        $this->reviewOption = ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->pluck('review_section_option_id', 'review_section_query_id')->toArray();

        $this->reviewComment = ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->pluck('comment', 'review_section_query_id')->toArray();

        $this->reviewSComment = ReviewSectionsComment::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->pluck('comment', 'review_section_id')->toArray();

        $this->article_journal_user = $this->record->article_journal_users()->where('user_id', $this->reviewer->id)->first();

        $this->review_decision = $this->article_journal_user->pivot->review_decision;
    }

    public function render()
    {
        $submission = $this->record->files()->whereHas('file_category', function ($query) {
            $query->where('code', '002');
        })->first();
        $article = $this->record;
        $this->sections   = ReviewSectionsGroup::all();
        $this->totalOptions = ReviewSection::all()->count();


        return view('livewire.backend.article-evaluation', compact('submission',  'article'));
    }

    public function upOptions($key, $value, $optionValue)
    {
        $this->reviewOption[$key] = $value;
        $this->reviewOptionValue[$key] = $optionValue;
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
        $optionValue = $this->reviewOptionValue;
        $comments = $this->reviewComment;
        $scomment = $this->reviewSComment;

        $rules = [];

        foreach ($this->sections as $subSection) {
            foreach ($subSection->reviewSections as $section) {
                $rules["reviewSComment.{$section->id}"] = 'required|string|min:5';
            }
        }

        $this->validate($rules, [
            'reviewSComment.*.required' => 'Please enter a comment.',
            'reviewSComment.*.string' => 'Comment must be valid text.',
        ]);


        // Ensure all options are selected
        $requiredOptionsCount = $this->totalOptions;
        $selectedOptionsCount = collect($this->reviewOption)->filter()->count();

        if ($selectedOptionsCount < $requiredOptionsCount) {
            session()->flash('response', [
                'status' => 'error',
                'message' => 'Please respond to all review sections before submitting your review.'
            ]);
            return;
        }

        //and $this->review_decision

        if ($this->review_decision == null) {
            session()->flash('response', [
                'status' => 'error',
                'message' => 'Please select a review decision before submitting your review.'
            ]);
            return;
        }



        // dd($options, $this->review_decision, $optionValue);
        ArticleReview::where('article_id', $this->record->id)->where('user_id', $this->reviewer->id)->delete();

        if (count(array_unique($optionValue)) == 1 && in_array('5', $optionValue) && $this->review_decision != 'accepted' && $this->review_decision != 'minor revision') {
            session()->flash('response', [
                'status'  => 'error',
                'message' => 'Review decision may not be rejected or major revision while all sections are indicated to be of the top quality'
            ]);
            return;
        }

        if (count(array_unique($optionValue)) == 1 && in_array('1', $optionValue) && $this->review_decision != 'rejected' && $this->review_decision != 'major revision') {
            session()->flash('response', [
                'status'  => 'error',
                'message' => 'Review decision may not be accepted while all sections are indicated to be very poor'
            ]);
            return;
        }

        if ((in_array('4', $optionValue) || in_array('5', $optionValue)) && $this->review_decision == 'rejected') {
            session()->flash('response', [
                'status'  => 'error',
                'message' => 'Review decision may not be rejected while sections are indicated to be of the top quality'
            ]);
            return;
        }

        if ((in_array('1', $optionValue) || in_array('2', $optionValue)) && ($this->review_decision == 'accepted' || $this->review_decision == 'minor revision')) {
            session()->flash('response', [
                'status'  => 'error',
                'message' => 'Review decision may not be accepted or minor review while some sections are indicated to be very poor or they need major revision'
            ]);
            return;
        }


        foreach ($options as $key => $value) {
            if ($value != '') {
                ArticleReview::create([
                    'article_id' => $this->record->id,
                    'review_section_query_id' => $key,
                    'review_section_option_id' => $value,
                    'user_id' => $this->reviewer->id
                ]);
            }
        }

        foreach ($comments as $key => $value) {
            if ($value != '') {
                ArticleReview::create([
                    'article_id' => $this->record->id,
                    'review_section_query_id' => $key,
                    'comment' => $value,
                    'user_id' => $this->reviewer->id
                ]);
            }
        }

        foreach ($scomment as $key => $value) {
            if ($value != '') {
                ReviewSectionsComment::create([
                    'article_id' => $this->record->id,
                    'review_section_id' => $key,
                    'comment' => $value,
                    'user_id' => $this->reviewer->id
                ]);
            }
        }


        $this->journal_user->article_journal_users()->sync([$this->record->id => [
            'review_decision' => $this->review_decision
        ]], false);


        if ($this->review_attachment) {
            $this->validate([
                'review_attachment.*' => 'mimes:pdf|max:2048'
            ]);

            foreach ($this->review_attachment as $attachment) {
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

        if ($state == 'complete') {
            $this->description = 'This Article Review is Complete and Submitted Back to the Editor for Further Processes';
            $this->journal_user->article_journal_users()->sync([$this->record->id => [
                'review_status'   => 'completed'
            ]], false);

            session()->flash('response', [
                'status'  => 'success',
                'message' => $this->description . ', We would like to extend our sinciere thanks for your careful review of our manuscript. Your expert comments have been invaluable in refining the manuscript and ensuring its rigor and clarity.'
            ]);

            // Mail::to('mrenatuskiheka@yahoo.com')
            //     ->send(new ReviewerResponse($this->record, $this->description));
        } else {
            session()->flash('response', [
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

        session()->flash('response', [
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

    public function articleStatus($code)
    {
        return ArticleStatus::where('code', $code)->first();
    }

    public function removeAttachment(ReviewAttachment $attachment)
    {
        if (file_exists(storage_path('app/public/review_attachments/' . $attachment->attachment))) {
            Storage::delete('public/review_attachments/' . $attachment->attachment);
            if ($attachment->delete()) {
                session()->flash('success', 'Attachment Deleted Successfully');
            }
        }
    }
}
