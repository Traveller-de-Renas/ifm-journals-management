<?php

namespace App\Livewire\Backend;

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
use Livewire\WithPagination;
use App\Models\ArticleStatus;
use App\Models\ReviewMessage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Submission extends Component
{
    use WithPagination, WithFileUploads;

    public $record;
    public $journal;
    public $title;
    public $abstract;
    public $country_id;
    public $country;
    public $article_type_id;
    public $article_type;
    public $issue_id;
    public $keywords;
    public $areas;
    public $pages = 0;
    public $words = 0;
    public $tables = 0;
    public $figures = 0;
    public $file_attachment;
    public $file_description;
    public $file_category_id;
    public $publish = 0;

    public $confirmations = [];
    public $issues = [];
    public $countries = [];
    public $file_categories = [];
    public $article_types = [];
    public $confirmed = [];

    public $sauthor;
    public $author_search;
    public $authors;
    public $author_number;

    public $salutations = [];
    public $create_juser = false;
    public $juser_fname, $juser_mname, $juser_lname, $juser_email, $juser_phone, $juser_affiliation, $juser_gender, $juser_salutation_id, $juser_country_id;
    public $filecategories;

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
        }

        $filecategories = FileCategory::where('status', 1)->where('submitted', $submission);

        $this->filecategories  = $filecategories->get();
        $this->file_categories = $filecategories->whereNotIn('id', $uploaded)->pluck('name', 'id')->toArray();

    

        $this->countries = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();

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

        if($this->record){
            if($this->record->article_status->code == '002'){
                $this->step = 4;
            }
        }

        return view('livewire.backend.submission');
    }

    public function store($status)
    {
        if($status == '006' || $status == '005'){
            $paper_id = explode('-R', $this->record->paper_id)[0];

            $resubmissions = $this->journal->articles()->where('paper_id', 'ilike', '%'.$paper_id.'%')->count();

            $paper_id = $paper_id.'-R'.$resubmissions;

            $this->record->update([
                'article_status_id' => $this->articleStatus('007')->id
            ]);
        }else{
            $month = date('m');
            $year  = date('Y');
            $paper_id = $this->journal->code.'-'.$month.'-'.$year.'-'.str_pad($this->journal->articles()->count() + 1, 5, '0', STR_PAD_LEFT);
        }
        
        $state = $this->articleStatus($status);

        $validator = Validator::make(
            [
                'title' => $this->title,
                'article_type_id' => $this->article_type_id,
                'country_id' => $this->country_id,
                'keywords' => $this->keywords,
                'areas'  => $this->areas,
                'tables' => $this->tables,
                'figures' => $this->figures,
                'words' => $this->words,
                'pages' => $this->pages,
            ],
            [
                'title' => 'required',
                'article_type_id' => 'required',
                'country_id' => 'required|integer',
                'keywords' => 'required|string',
                'areas'  => 'required|string',
                'tables' => 'required|integer',
                'figures' => 'required|integer',
                'words' => 'required|integer',
                'pages' => 'required|integer',
                'confirmed.*' => 'required|in:1'
            ], attributes: [
                'article_type_id' => 'Article Type',
                'country_id' => 'Country'
            ]);
    
        if ($validator->fails()) {
            $this->setStep(1);
        } 
        
        $validator->validate();

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
            'user_id'           => auth()->user()->id
        ]);


        if($status == '002'){
            $article->update([
                'submission_date' => date('Y-m-d')
            ]);

            if(ReviewMessage::where('category', 'Submission')->count() > 0){

                Mail::to('mrenatuskiheka@yahoo.com')
                    ->send(new Submissions($article));

            }
        }


        //Notification 
        if($status == '002' || $status == '006')
        {
            $journal_user = $this->journal->journal_us()->whereHas('roles', function ($query) {
                $query->where('name', 'Supporting Editor');
            })->first();

            if($status == '006'){

                $journal_user = $this->record->article_journal_users()->whereHas('roles', function ($query) {
                    $query->where('name', 'Associate Editor');
                })->first();

            }

            Notification::create([
                'article_id' => $article->id,
                'journal_user_id' => $journal_user->id,
                'status' => 1
            ]);
        }

        $this->record = $article;

        foreach($this->journal->confirmations as $key => $confirmation){
            $value = 'No';
            
            if(isset($this->confirmations[$key]) && $this->confirmations[$key] == 1){
                $value = 'Yes';
            }
                
            $article->submission_confirmations()->sync([$confirmation->id => ['value' => $value]], false);
        }

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'Manuscript is Saved and Submitted successfully'
        ]);
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


    public function update($status)
    {
        $state = $this->articleStatus($status);

        $validator = Validator::make(
            [
                'title' => $this->title,
                'article_type_id' => $this->article_type_id,
                'country_id' => $this->country_id,
                'keywords' => $this->keywords,
                'areas'  => $this->areas,
                'tables' => $this->tables,
                'figures' => $this->figures,
                'words' => $this->words,
                'pages' => $this->pages,
            ],
            [
                'title' => 'required',
                'article_type_id' => 'required',
                'country_id' => 'required|integer',
                'keywords' => 'required|string',
                'areas'  => 'required|string',
                'tables' => 'required|integer',
                'figures' => 'required|integer',
                'words' => 'required|integer',
                'pages' => 'required|integer',
            ], attributes: [
                'article_type_id' => 'Article Type',
                'country_id' => 'Country'
            ]);
    
        if ($validator->fails()) {
            $this->setStep(1);
        } 
        
        $validator->validate();
        
        $this->record->title             = $this->title;
        $this->record->abstract          = $this->abstract;
        $this->record->article_type_id   = $this->article_type_id;
        $this->record->country_id        = $this->country_id;
        $this->record->keywords          = $this->keywords;
        $this->record->areas             = $this->areas;
        $this->record->pages             = $this->pages;
        $this->record->words             = $this->words;
        $this->record->tables            = $this->tables;
        $this->record->figures           = $this->figures;
        $this->record->article_status_id = $state->id;
        

        if($status == '002'){
            $this->record->submission_date = date('Y-m-d');

            $month = date('m');
            $year  = date('Y');
            $paper_id = $this->journal->code.'-'.$month.'-'.$year.'-'.str_pad($this->journal->articles()->count() + 1, 5, '0', STR_PAD_LEFT);
            $this->record->paper_id = $paper_id;

            if(ReviewMessage::where('category', 'Submission')->count() > 0){
                Mail::to('mrenatuskiheka@yahoo.com')
                    ->send(new Submissions($this->record));
            }
        }

        $this->record->update();

        if($status == '002' || $status == '006')
        {
            $journal_user = $this->journal->journal_us()->whereHas('roles', function ($query) {
                $query->where('name', 'Supporting Editor');
            })->first();

            if($status == '006'){

                $journal_user = $this->record->article_journal_users()->whereHas('roles', function ($query) {
                    $query->where('name', 'Associate Editor');
                })->first();

            }

            Notification::create([
                'article_id' => $this->record->id,
                'journal_user_id' => $journal_user->id,
                'status' => 1
            ]);
        }

        foreach($this->journal->confirmations as $key => $confirmation){
            $value = 'No';
            
            if(isset($this->confirmations[$key]) && $this->confirmations[$key] == 1){
                $value = 'Yes';
            }
            
            $this->record->submission_confirmations()->sync([$confirmation->id => ['value' => $value]], false);
        }

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'Manuscript is Saved and Submitted successfully'
        ]);
    }


    public function delete()
    {
        $this->record->delete();
    }


    public function uploadDocument()
    {
        $this->validate([
            'file_attachment'  => 'nullable|file|max:14024|mimes:doc,docx',
            'file_category_id' => 'required'
        ]);
    
        if ($this->record == null) {
            $this->store('001');
        }else{
            if(in_array($this->record->article_status->code, ['019', '020'])){ //Returned with Comments
                $this->store('005'); //Pending Resubmission
            }
        }

        $category = FileCategory::find($this->file_category_id);
        $randomno = rand(1000, 9999);
    
        $file  = $this->file_attachment;
        $_name = $file->getClientOriginalName();
        $_type = $file->getClientOriginalExtension();
        $_file = str_replace(' ', '_', $category->code.'-'.$randomno.'-'.$_name);
    
        $file->storeAs('/articles', $_file);

        
    
        $article_file = new File;
        $article_file->file_path        = $_file;
        $article_file->file_type        = $_type;
        $article_file->file_category_id = $this->file_category_id;
        $article_file->article_id       = $this->record->id;

        $article_file->save();
    
        $this->file_attachment  = null;
        $this->file_category_id = null;
        $this->file_description = null;
    
        session()->flash('file_uploaded', 'File uploaded successfully');
    }

    public $step = 1;

    public function incrementStep()
    {
        $this->dispatch('contentChanged');
        $this->step++;
    }

    public function decrementStep()
    {
        $this->dispatch('contentChanged');
        $this->step--;
    }

    public function setStep($step)
    {
        $this->dispatch('contentChanged');
        $this->step = $step;
    }


    public function searchAuthor($string)
    {
        if($string != ''){
            $selected = $this->record->article_journal_users()->where('number', '>', 0)->pluck('user_id')->toArray();

            $this->author_search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            $this->authors = User::when($this->author_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->author_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->author_search.'%')->orWhere('last_name', 'ilike', '%'.$this->author_search.'%');
                });
            })->whereNotIn('id', $selected)->orderBy('first_name', 'ASC')->get();
        }
    }

    public function assignAuthor(User $author)
    {
        
        if ($this->record == null) {
            $this->store('001');
        }else{
            if(in_array($this->record->article_status->code, ['019', '020'])){ //Returned with Comments
                $this->store('005'); //Pending Resubmission
            }
        }

        $max_no    = $this->record->article_journal_users()->where('number', '>', 0)->count();
        $author_no = $max_no++;

        $journal_us = JournalUser::firstOrCreate([
            'user_id' => $author->id,
            'journal_id' => $this->journal->id
        ], [
            'user_id' => $author->id,
            'journal_id' => $this->journal->id
        ]);

        if(!($journal_us->hasRole('Author'))){
            $journal_us->assignRole('Author');
        }

        $this->record->article_journal_users()->sync([$journal_us->id => [
             'number' => $author_no]], false);

             $this->authors = [];
             $this->sauthor != '';
    }

    public function removeAuthor(JournalUser $author)
    {
        $juser = $author->article_journal_users()->where('article_id', $this->record->id)->first();

        $others = $this->record->article_journal_users()->where('number', '>', $juser->pivot->number)->get();
        foreach($others as $key => $value){
            $value->updateExistingPivot($value->pivot->user_id,
                ['number' => $value->pivot->number - 1]
            );
        }

        $author->article_journal_users()->detach($this->record->id);
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

        if($type == 'up'){
            $other = $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('article_id', $pivot->article_id)
            ->wherePivot('number', $pivot->number - 1)->first();

            $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('id', $other->pivot->id)
            ->updateExistingPivot($other->pivot->user_id,
                ['role' => 'author', 'number' => $other->pivot->number + 1]
            );

            $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('id', $pivot->id)
            ->updateExistingPivot($pivot->user_id,
                ['role' => 'author', 'number' => $pivot->number - 1]
            );
            
        }

        if($type == 'down'){
            // $this->record->article_users()
            // ->where('role', 'author')
            // ->wherePivot('user_id', $pivot->user_id)
            // ->wherePivot('article_id', $pivot->article_id)
            // ->updateExistingPivot($pivot->user_id,
            //     ['role' => 'author', 'number' => $pivot->number + 1]
            // );

            $other = $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('article_id', $pivot->article_id)
            ->wherePivot('number', $pivot->number + 1)->first();

            $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('id', $other->pivot->id)
            ->updateExistingPivot($other->pivot->user_id,
                ['role' => 'author', 'number' => $other->pivot->number - 1]
            );

            $this->record->article_users()
            ->where('role', 'author')
            ->wherePivot('id', $pivot->id)
            ->updateExistingPivot($pivot->user_id,
                ['role' => 'author', 'number' => $pivot->number + 1]
            );
        }
    }

    public function articleStatus($code){
        return ArticleStatus::where('code', $code)->first();
    }
}
