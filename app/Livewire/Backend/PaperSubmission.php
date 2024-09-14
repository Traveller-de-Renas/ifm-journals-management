<?php

namespace App\Livewire\Backend;

use App\Models\File;
use App\Models\User;
use App\Models\Article;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use App\Models\ArticleType;
use Illuminate\Support\Str;
use App\Models\FileCategory;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PaperSubmission extends Component
{
    use WithPagination, WithFileUploads;

    public $record;
    public $journal;
    public $title;
    public $abstract;
    public $country_id;
    public $article_type_id;
    public $issue_id;
    public $keywords;
    public $areas;
    public $pages;
    public $words;
    public $tables;
    public $figures;
    public $attachment;
    public $file_description;
    public $file_category_id;

    public $confirmations = [];
    public $issues = [];
    public $countries = [];
    public $file_categories = [];
    public $article_types = [];

    public $sauthor;
    public $author_search;
    public $author_names;

    public $salutations = [];
    public $create_juser = false;
    public $juser_fname, $juser_mname, $juser_lname, $juser_email, $juser_phone, $juser_affiliation, $juser_gender, $juser_salutation_id, $juser_country_id;

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

        $this->article_types = ArticleType::where('journal_id', $this->journal->id)->get()->pluck('name', 'id')->toArray();
        $this->file_categories = FileCategory::all()->pluck('name', 'id')->toArray();

        $this->countries = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();

        $this->dispatch('contentChanged');
    }
    
    public function render()
    {
        return view('livewire.backend.paper-submission');
    }

    public function store($status)
    {
        $article = Article::create([
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
            'status'            => $status,
            'user_id'           => auth()->user()->id
        ]);

        $this->record = $article;

        Auth::user()->journals()->sync([$this->journal->id => ['role' => 'author']]);

        foreach($this->journal->confirmations as $key => $confirmation){
            $value = 'No';
            
            if(isset($this->confirmations[$key]) && $this->confirmations[$key] == 1){
                $value = 'Yes';
            }
                
            $article->submission_confirmations()->sync([$confirmation->id => ['value' => $value]], false);
        }

        session()->flash('success', 'Saved successfully');
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
        $this->record->update([
            'title'             => $this->title,
            'abstract'          => $this->abstract,
            'article_type_id'   => $this->article_type_id,
            'country_id'        => $this->country_id,
            'keywords'          => $this->keywords,
            'areas'             => $this->areas,
            'pages'             => $this->pages,
            'words'             => $this->words,
            'tables'            => $this->tables,
            'figures'           => $this->figures,
            'status'            => $status
        ]);

        foreach($this->journal->confirmations as $key => $confirmation){
            $value = 'No';
            
            if(isset($this->confirmations[$key]) && $this->confirmations[$key] == 1){
                $value = 'Yes';
            }
                
            $this->record->submission_confirmations()->sync([$confirmation->id => ['value' => $value]], false);
        }

        session()->flash('success', 'Saved successfully');
    }


    public function delete()
    {
        $this->record->delete();
    }


    public function uploadDocument()
    {
        $this->validate([
            'attachment' => 'nullable|file|max:4024|mimes:pdf,doc,docx',
            'file_category_id' => 'required'
        ]);
    
        if ($this->record == null) {
            $this->store('Pending');
        }
    
        $file  = $this->attachment;
        $_name = $file->getClientOriginalName();
        $_type = $file->getClientOriginalExtension();
        $_file = str_replace(' ', '_', $_name);
    
        $file->storeAs('public/articles/', $_file);
    
        $article_file = new File;
        
        $article_file->file_path        = $_file;
        $article_file->file_type        = $_type;
        $article_file->file_description = $this->file_description;
        $article_file->file_category_id = $this->file_category_id;
        $article_file->article_id       = $this->record->id;

        $article_file->save();
    
        $this->attachment       = null;
        $this->file_category_id = null;
        $this->file_description = null;
    
        session()->flash('file_uploaded', 'File uploaded successfully');
    }

    public $step = 1;

    public function incrementStep()
    {
        $this->step++;
    }

    public function decrementStep()
    {
        $this->step--;
    }

    public function setStep($step)
    {
        $this->step = $step;
    }


    public function searchAuthor($string)
    {
        if($string != ''){
            $this->author_search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            $this->author_names = User::when($this->author_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->author_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->author_search.'%')->orWhere('last_name', 'ilike', '%'.$this->author_search.'%');
                });
            })->orderBy('first_name', 'ASC')->get();
        }
    }

    public function assignAuthor(User $author)
    {
        $this->sauthor = '';

        if ($this->record == null) {
            $this->store('Pending');
        }

        $author->articles()->sync([$this->record->id => ['role' => 'author']], false);
    }

    public function removeAuthor(User $author)
    {
        $author->articles()->detach($this->record->id);

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
        ]);

        $this->reset(['juser_fname', 'juser_mname', 'juser_lname', 'juser_email', 'juser_phone', 'juser_affiliation']);

        $this->assignAuthor($juser);

        $this->create_juser = false;
    }

}
