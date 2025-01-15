<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use App\Models\Country;
use Livewire\Component;
use App\Mail\EditorMail;
use App\Mail\ReviewerMail;
use App\Models\Salutation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleReview;
use App\Models\ArticleStatus;
use App\Models\ReviewSection;
use App\Models\ArticleMovementLog;
use Illuminate\Support\Facades\Hash;
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
    public $viewFeedback = false;

    public $sections;
    public $reviewOption  = [];
    public $reviewComment = [];
    public $review_attachment;

    public $editors;
    public $role;

    public $volume;
    public $issue;
    public $volumes = [];
    public $issues  = [];

    public $user_id;
    public $country_id;
    public $salutation_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $country;
    public $zipcode;

    public $salutations;
    public $countries;
    
    public function mount(Request $request){
        if(!Str::isUuid($request->article)){
            abort(404);
        }
        
        $this->record = Article::where('uuid', $request->article)->first();
        if(empty($this->record)){
            abort(404);
        }

        $this->reviewers   = User::all();
        $this->editors     = $this->record->journal->editors;
        $this->countries   = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();
    }
    
    public function render()
    {
        $volume_all    = $this->record->journal->volumes;
        $this->volumes = $volume_all->pluck('description', 'id')->toArray();
        $this->issues  = Issue::where('volume_id', $this->volume)->get()->pluck('description', 'id')->toArray();

        $statuses = ArticleStatus::all();

        return view('livewire.backend.article-details', compact('statuses'));
    }

    public function declineArticle()
    {
        $this->dispatch('contentChanged');
        $this->declineModal = true;
    }

    public function reviewFeedback(User $reviewer)
    {
        $this->reviewOption     = ArticleReview::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('review_section_option_id', 'review_section_query_id')->toArray();
        $this->reviewComment    = ArticleReview::where('article_id', $this->record->id)->where('user_id', $reviewer->id)->pluck('comment', 'review_section_query_id')->toArray();
        $this->sections         = ReviewSection::all();
        $this->reviewerFeedback = true;
    }


    public function attachUser()
    {
        $this->validate([
            'user_id' => 'required'
        ]);
        
        $this->record->article_users()->sync([$this->user_id => ['role' => 'editor']], false);
        $this->record->article_status_id = $this->articleStatus('014')->id;
        $this->record->save();

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
            'article_id'  => $this->record->id,
            'user_id'     => auth()->user()->id,
            'description' => $this->description,
        ]);

        $this->record->article_status_id = $this->articleStatus('013')->id;
        $this->record->save();
        session()->flash('success', 'This manuscript is returned back to the author!');

        $this->reset(['description']);
    }

    public function toChiefEditor()
    {
        $mlog = ArticleMovementLog::create([
            'article_id'  => $this->record->id,
            'user_id'     => auth()->user()->id,
            'description' => $this->description
        ]);

        $this->record->article_status_id = $this->articleStatus('003')->id;
        $this->record->save();
        session()->flash('success', 'These Recommendations are Successifully Sent to Chief Editor');

        $this->reset(['description']);
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

        if($status == '006'){
            if($this->record->journal->volume_id != '' && $this->record->journal->issue_id != ''){
                $this->record->volume_id         = $this->record->journal->volume_id;
                $this->record->issue_id          = $this->record->journal->issue_id;
                $this->record->publication_date  = now();
            }else{
                session()->flash('danger', 'This manuscript cannot be published, No Volume or Issue has been created!');
                return false;
            }
        }

        $this->record->update();
        session()->flash('success', 'Article status is Successifully Updated');
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }



















    public $tab = 'taba';
    public $user_search;
    public $user_names;
    public $user_detail;
    public $create_newuser = false;

    public function searchUser($string)
    {
        if($string != ''){
            $this->user_search = trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9]/', '', urldecode(html_entity_decode(strip_tags($string))))));
            $this->user_names  = User::when($this->user_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->user_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->user_search.'%')->orWhere('last_name', 'ilike', '%'.$this->user_search.'%');
                });
            })->orderBy('first_name', 'ASC')->get();
        }
    }

    public function assignUser(User $user, $assignto, $category)
    {
        $this->user_search = '';

        if($assignto == 'journal'){
            $user->journals()->attach([$this->record->id => ['role' => $category]]);
        }

        if($assignto == 'article'){
            $user->article_users()->attach([$this->record->id => ['role' => $category]]);

            if($category == 'reviewer'){
                $this->record->article_status_id = $this->articleStatus('004')->id;
                $this->record->save();

                //Mail::to('mrenatuskiheka@yahoo.com')->send(new ReviewerMail($this->record));
                Mail::to('mrenatuskiheka@yahoo.com')
                    ->send(new ReviewerMail($this->record));
                
                session()->flash('success', 'Reviewer is Assigned successfully');
            }
        }

    }

    public function removeUser(User $user, $remove_from, $category)
    {
        if($remove_from == 'journal'){
            $user->journals()->detach($this->record->id);
        }

        if($remove_from == 'article'){
            $user->article_users()->detach($this->record->id);

            if($category == 'reviewer' && $this->record->article_users()->wherePivot('role', 'reviewer')->get()->count() < 1){
                $this->record->article_status_id = $this->articleStatus('003')->id;
                $this->record->save();
            }
        }
        
    }

    public function editorDetails($key)
    {
        if ($key == $this->editor_detail) {
            $this->user_detail = '';
        }else{
            $this->user_detail = $key;
        }
    }

    public function createNewUser()
    {
        $this->create_newuser = true;
    }

    public function storeNewUser()
    {
        $this->validate([
            'juser_fname'       => 'required',
            'juser_mname'       => 'nullable',
            'juser_lname'       => 'required',
            'juser_email'       => 'nullable|email|unique:users,email',
            'juser_phone'       => 'nullable|numeric',
            'juser_affiliation' => 'nullable'
        ]);

        $newuser = User::create([
            'first_name'   => $this->juser_fname,
            'middle_name'  => $this->juser_mname,
            'last_name'    => $this->juser_lname,
            'gender'       => $this->juser_gender,
            'email'        => $this->juser_email,
            'phone'        => $this->juser_phone,
            'affiliation'  => $this->juser_affiliation,
            'country_id'   => $this->juser_country_id,
            'password'     => Hash::make('admin@ifm123EMS'),
        ]);

        $this->reset(['juser_fname', 'juser_mname', 'juser_lname', 'juser_email', 'juser_phone', 'juser_affiliation']);

        $this->assignUser($newuser, 'article', 'reviewer');

        $this->create_newuser = false;
    }



    public function changeTab($tab)
    {
        $this->dispatch('contentChanged');
        $this->tab = $tab;
    }
}
