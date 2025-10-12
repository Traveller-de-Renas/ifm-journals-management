<?php

namespace App\Livewire\Backend;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Article;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Mail\Submissions;
use App\Models\Salutation;
use App\Models\ArticleType;
use App\Models\JournalUser;
use Illuminate\Support\Str;
use App\Models\FileCategory;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ArticleStatus;
use App\Models\ReviewMessage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\SubmissionConfirmation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubmissionManually extends Component
{
    use WithFileUploads;

    public $record;
    public $journal;
    public $title;
    public $abstract;
    public $country_id;
    public $country;
    public $article_type_id;
    public $article_type, $submission_date;
    public $issue_id;
    public $keywords;
    public $areas;
    public $pages = 0;
    public $words = 0;
    public $tables = 0;
    public $figures = 0;
    public $manuscript_file;
    public $publish = 0;

    public $confirmations = [];
    public $issues = [];
    public $countries = [];
    public $file_categories = [];
    public $article_types = [];
    public $confirmed = [];

    public $sauthor, $author;
    public $author_search;
    public $authors;
    public $author_number, $selected_authors;

    public $salutations = [];
    public $create_juser = false;
    public $juser_fname, $juser_mname, $juser_lname, $juser_email, $juser_phone, $juser_affiliation, $juser_gender, $juser_salutation_id, $juser_country_id;
    public $filecategories;


    public $author_juser, $journal_users, $submitted_by;

    public function mount(Request $request)
    {
        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->journal = Journal::where('uuid', $request->journal)->first();
        if(empty($this->journal)){
            abort(404);
        }

        if($request->article != ''){
            if(!Str::isUuid($request->article))
            {
                if(empty($this->record)){
                    abort(404);
                }
            }else{
                $this->record = Article::where('uuid', $request->article)->first();
                $this->edit($this->record);
            }
        }

        $this->article_types  = ArticleType::where('journal_id', $this->journal->id)->get()->pluck('name', 'id')->toArray();
        

        $uploaded   = [];
        $submission = 'submission';

        if($this->record){
            $uploaded   = $this->record?->files()->pluck('file_category_id')->toArray();
            if(in_array($this->record->article_status->code, ['019', '020'])){
                $submission = 'resubmission';
            }

            $this->confirmed = $this->record?->submission_confirmations()->pluck('value','submission_confirmation_id')->toArray();
        }

        $filecategories = FileCategory::where('status', 1)->where('submitted', $submission);

        $this->filecategories  = $filecategories->get();
        $this->file_categories = $filecategories->whereNotIn('id', $uploaded)->pluck('name', 'id')->toArray();

        $this->countries     = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations   = Salutation::where('status', 1)->pluck('title', 'id')->toArray();
        $this->confirmations = SubmissionConfirmation::where('status', 1)->get();

        $this->author_juser  = auth()->user()->journal_us()->where('journal_id', $this->journal->id)->first();

        $this->dispatch('contentChanged');
    }
    
    public function render()
    {
        if($this->article_type_id){
            $this->article_type = ArticleType::find($this->article_type_id);
        }

        if($this->country_id){
            $this->country = Country::find($this->country_id);
        }

        $journal_users = User::whereHas('journal_us', function ($query) {
            $query->where('journal_id', $this->journal->id);
        })->get();

        $this->journal_users = $journal_users->mapWithKeys(function ($user) {
            $fullName = trim(($user->salutation->title ?? '') . ' ' .
                            $user->first_name . ' ' .
                            $user->middle_name . ' ' .
                            $user->last_name);
            return [$user->id => $fullName];
        })->toArray();

        return view('livewire.backend.submission-manually');
    }

    public function store()
    {
        DB::transaction(function () {
            $date     = Carbon::parse($this->submission_date);
            $month    = $date->format('M');
            $year     = $date->format('Y');
            $paper_id = strtoupper($this->journal->code).'-'.$month.'-'.$year.'-'.str_pad($this->journal->articles()->count() + 1, 5, '0', STR_PAD_LEFT);
        
        
            $validator = Validator::make(
            [
                'title'           => $this->title,
                'article_type_id' => $this->article_type_id,
                'country_id'      => $this->country_id,
                'keywords'        => $this->keywords,
                'areas'           => $this->areas,
                'tables'          => $this->tables,
                'figures'         => $this->figures,
                'words'           => $this->words,
                'pages'           => $this->pages,
                'manuscript_file' => $this->manuscript_file,
            ],
            [
                'title'             => 'required',
                'article_type_id'   => 'required',
                'country_id'        => 'required|integer',
                'keywords'          => 'required|string',
                'areas'             => 'required|string',
                'tables'            => 'required|integer',
                'figures'           => 'required|integer',
                'words'             => 'required|integer',
                'pages'             => 'required|integer',
                'manuscript_file'   => 'required|file|max:9024|mimes:pdf|mimetypes:application/pdf',
            ], attributes: [
                'article_type_id' => 'Article Type',
                'country_id'      => 'Country',
                'manuscript_file' => 'Manuscript File'
            ]);
            
            $validator->validate();

            $author = User::find($this->submitted_by);
            $auth_journal_user = $author->journal_us()->where('journal_id', $this->journal->id)->first();

            $state = $this->articleStatus('013');
            $article = Article::create([
                'paper_id'          => $paper_id,
                'title'             => $this->title,
                'abstract'          => $this->abstract,
                'article_type_id'   => $this->article_type_id,
                'country_id'        => $this->country_id,
                'journal_id'        => $this->journal->id,
                'keywords'          => $this->keywords,
                'areas'             => $this->areas,
                'pages'             => $this->pages,
                'words'             => $this->words,
                'tables'            => $this->tables,
                'figures'           => $this->figures,
                'article_status_id' => $state->id,
                'deadline'          => Carbon::now()->addDays($state->max_days),
                'user_id'           => $this->submitted_by,
                'submission_date'   => $this->submission_date,
                'manuscript_file'   => $paper_id . '.pdf',
            ]);

            if ($this->manuscript_file) {
                $_name = $this->manuscript_file->getClientOriginalName();
                $_type = $this->manuscript_file->getClientOriginalExtension();

                $this->manuscript_file->storeAs('publications/', $article->paper_id . '.pdf');
            }

            $article->article_journal_users()->sync([$auth_journal_user->id => ['number' => 1]], false);

            //Assign Authors
            if(!empty($this->selected_authors)){
                $author_no = 2;
                foreach ($this->selected_authors as $author) {
                    $journal_us = JournalUser::firstOrCreate([
                        'user_id' => $author->id,
                        'journal_id' => $this->journal->id
                    ],[
                        'user_id' => $author->id,
                        'journal_id' => $this->journal->id
                    ]);

                    $article->article_journal_users()->sync([$journal_us->id => ['number' => $author_no]], false);

                    if(!($journal_us->hasRole('Author'))){
                        $journal_us->assignRole('Author');
                    }

                    $author_no++;
                }
            }

            $this->record = $article;

            session()->flash('response',[
                'status'  => 'success',
                'message' => 'Manuscript Submitted Successifully'
            ]);
        });
    }


    public function edit(){
        $this->title            = $this->record->title;
        $this->abstract         = $this->record->abstract;
        $this->article_type_id  = $this->record->article_type_id;
        $this->country_id       = $this->record->country_id;
        $this->keywords         = $this->record->keywords;
        $this->areas            = $this->record->areas;
        $this->pages            = $this->record->pages;
        $this->words            = $this->record->words;
        $this->tables           = $this->record->tables;
        $this->figures          = $this->record->figures;
    }


    public function delete()
    {
        $this->record->delete();
    }



    public function deleteFile(File $file)
    {
        $file->delete();

        if (Storage::exists('articles/'.$file->file_path)) {
            Storage::delete('articles/'.$file->file_path);
        }

    }




    public function searchAuthor($string)
    {
        if($string != ''){
            $selected = [];
            if(!empty($this->selected_authors)){
                
                foreach ($this->selected_authors as $author) {
                    $selected[] = $author->id;
                }
            }

            $this->author_search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            
            $authors = User::when($this->author_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->author_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->author_search.'%')->orWhere('last_name', 'ilike', '%'.$this->author_search.'%');
                });
            });
            
            if($selected){
                $authors = $authors->whereNotIn('id', $selected);
            }

            $this->authors = $authors->orderBy('first_name', 'ASC')->get();
        }
    }

    public function selectAuthor(User $author)
    {
        $this->selected_authors[] = $author;

        $this->authors = [];
        $this->sauthor = '';

    }

    public function removeAuthor($key)
    {
        unset($this->selected_authors[$key]);
    }


    public function createJuser()
    {
        $this->create_juser = true;
    }

    public function storeJuser()
    {
        $this->validate([
            'juser_fname'       => 'required',
            'juser_mname'       => 'nullable',
            'juser_lname'       => 'required',
            'juser_email'       => 'nullable|email|unique:users,email',
            'juser_phone'       => 'nullable|numeric',
            'juser_affiliation' => 'nullable'
        ]);

        $juser = User::create([
            'first_name'   => $this->juser_fname,
            'middle_name'  => $this->juser_mname,
            'last_name'    => $this->juser_lname,
            'gender'       => $this->juser_gender,
            'email'        => $this->juser_email,
            'phone'        => $this->juser_phone,
            'affiliation'  => $this->juser_affiliation,
            'country_id'   => $this->juser_country_id,
            'password'     => Hash::make('admin@ifm123EMS'),
            'added'        => 1
        ]);

        $this->reset(['juser_fname', 'juser_mname', 'juser_lname', 'juser_email', 'juser_phone', 'juser_affiliation']);

        $this->assignAuthor($juser);

        $this->create_juser = false;
    }


    public function changeOrder($pivot, $type)
    {
        $pivot =  (object) $pivot;

        $author = $this->record->article_journal_users()->whereHas('roles', function ($query) {
            $query->where('name', 'Author');
        })->where('number', $pivot->number)->first();

        if($type == 'up'){
            //select the upper author
            $upper = $this->record->article_journal_users()->whereHas('roles', function ($query) {
                $query->where('name', 'Author');
            })->where('number', $pivot->number - 1)->first();

            $this->record->article_journal_users()->sync([$upper->id => ['number' => $pivot->number]], false);
            $this->record->article_journal_users()->sync([$author->id => ['number' => $pivot->number - 1]], false);

        }

        if($type == 'down'){
            //select the lower author
            $lower = $this->record->article_journal_users()->whereHas('roles', function ($query) {
                $query->where('name', 'Author');
            })->where('number', $pivot->number + 1)->first();

            $this->record->article_journal_users()->sync([$lower->id => ['number' => $pivot->number]], false);
            $this->record->article_journal_users()->sync([$author->id => ['number' => $pivot->number + 1]], false);
        }
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }

    public function cancel()
    {
        return redirect()->route('journals.submission_manually', $this->journal?->uuid);
    }
}
