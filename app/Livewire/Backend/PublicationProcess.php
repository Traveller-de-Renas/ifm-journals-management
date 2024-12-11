<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Category;
use App\Models\Salutation;
use App\Models\ArticleType;
use App\Models\ArticleStatus;
use App\Models\JournalInstruction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class PublicationProcess extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $subjects;
    public $categories;

    public $signupModal = false;
    public $journal;

    public $selectedSubjects = [];
    public $selectedCategories = [];

    public function mount()
    {
    }

    public function render()
    {
        $this->subjects   = Subject::all();
        $this->categories = Category::all();
        
        $data = Journal::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%')->orWhere('description', 'ilike', '%' . $this->query . '%')->orWhere('publisher', 'ilike', '%' . $this->query . '%');
            });
        })->when($this->selectedSubjects, function ($query) {

            $query->whereIn('subject_id', $this->selectedSubjects);

        })->when($this->selectedCategories, function ($query) {

            $query->whereIn('category_id', $this->selectedCategories);

        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $data = $data->paginate(5);

        return view('livewire.backend.publication-process', compact('data'));
    }

    public function signup(Journal $journal)
    {
        $this->journal = $journal;
        $this->signupModal = true;
    }

    public function confirmSignUp()
    {
        Auth::user()->journals()->sync([$this->journal->id => ['role' => 'author']]);
        $this->signupModal = false;
        
        session()->flash('success', 'You are successfully registered as an author on this journal');
    }

    public function checkOption($opt, $value)
    {
        if($opt == 'subjects'){
            if(!in_array($value, $this->selectedSubjects)){
                $this->selectedSubjects[] = $value;
            }else{
                $key = array_search($value, $this->selectedSubjects);
                if ($key !== false) {
                    unset($this->selectedSubjects[$key]);
                }
            }
        }

        if($opt == 'categories'){
            if(!in_array($value, $this->selectedCategories)){
                $this->selectedCategories[] = $value;
            }else{
                $key = array_search($value, $this->selectedCategories);
                if ($key !== false) {
                    unset($this->selectedCategories[$key]);
                }
            }
        }

    }


    public function loadFromJSON(){
        $file = File::get('storage/journals.json');

        $journals = json_decode($file);

        foreach($journals->getJournals as $journal){

            $the_journal = Journal::updateOrCreate([
                'code' => $journal->code
            ],[
                'title' => $journal->title,
                'code' => $journal->code,
                'doi' => $journal->doi,
                'issn' => $journal->issn,
                'eissn' => $journal->eissn,
                'description' => $journal->description,
                'scope' => $journal->scope,
                'year' => $journal->year,
                'email' => $journal->code.'@ifm.ac.tz',
                'user_id' => auth()->user()->id,
                'image' => $journal->image
            ]);



            if($journal->guidlines){
                foreach($journal->guidlines as $key => $instruction)
                {
                    JournalInstruction::create([
                        'title' => $instruction->Heading,
                        'description' => $instruction->Contents,
                        'journal_id'  => $the_journal->id
                    ]);
                }
            }


            foreach($journal->volumes as $key => $volume)
            {
                $volumex = Volume::create([
                    'number' => $volume->volume_number,
                    'description' => 'Volume '.$volume->volume_number,
                    'journal_id'  => $the_journal->id
                ]);

                foreach($volume->issues as $key => $issue)
                {
                    Issue::create([
                        'number' => $issue->IssueNumber,
                        'description' => 'Issue '.$issue->IssueNumber,
                        'journal_id' => $the_journal->id,
                        'volume_id' => $volumex->id,
                        'publication_date' => $issue->DatePublished,
                        'status' => 'Published'
                    ]);
                }
            }


            if($journal->articles){
                foreach($journal->articles as $key => $article){

                    $article_type = ArticleType::firstOrCreate([
                        'name'=> $article->article_type,
                        'journal_id' => $the_journal->id
                    ],[
                        'name'=> $article->article_type,
                        'journal_id' => $the_journal->id,
                        'description' => $article->article_type,
                    ]);



                    $salutation = Salutation::firstOrCreate([
                        'title'=> $article->salutation
                    ],[
                        'title'=> $article->salutation
                    ]);



                    $gender = 'Male';

                    if($article->salutation == 'Mr'){
                        $gender = 'Male';
                    }

                    if($article->salutation == 'Ms'){
                        $gender = 'Female';
                    }


                    $email = $article->email;
                    if($article->email == ''){
                        $email = strtolower($article->first_name.$article->middle_name.$article->last_name).'@ifm.ac.tz';
                    }


                    $user = User::firstOrCreate([
                        'email'=> $email
                    ],[
                        'email'=> $email,
                        'first_name' => $article->first_name,
                        'middle_name' => $article->middle_name,
                        'last_name' => $article->last_name,
                        'gender' => $gender,
                        'salutation_id' => $salutation->id,
                        'password' => Hash::make('123@Journals')
                    ]);



                    $volume = Volume::firstOrCreate(
                        [
                            'number' => $article->volume->VolumeNumber,
                            'journal_id' => $the_journal->id
                        ],
                        [
                            'number' => $article->volume->VolumeNumber,
                            'description' => 'Volume '.$article->volume->VolumeNumber,
                            'journal_id'  => $the_journal->id
                        ]
                    );



                    $issue = Issue::firstOrCreate(
                        [
                            'number' => $article->issue->IssueNumber,
                            'volume_id' => $volume->id,
                            'journal_id' => $the_journal->id
                        ],
                        [
                            'number' => $article->issue->IssueNumber,
                            'volume_id' => $volume->id,
                            'journal_id' => $the_journal->id,
                            'status' => 'Published'
                        ]
                    );

                    $status = ArticleStatus::where('code', '006')->first();
                    $artc = Article::create([
                        'title'             => $article->article_title,
                        'abstract'          => $article->abstract,
                        'article_type_id'   => $article_type->id,
                        'journal_id'        => $the_journal->id,
                        'keywords'          => $article->keywords,
                        'areas'             => $article->areas,
                        'article_status_id' => $status->id,
                        'user_id'           => $user->id,
                        'volume_id'         => $volume->id,
                        'issue_id'          => $issue->id
                    ]);
            
                    $user->journals()->sync([$the_journal->id => ['role' => 'author']]);
                }
            }
        }
    }
}
