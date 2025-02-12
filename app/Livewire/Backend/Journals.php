<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use App\Mail\EditorialTeam;
use App\Models\ArticleType;
use App\Models\JournalUser;
use App\Models\ArticleStatus;
use App\Models\ReviewMessage;
use App\Models\JournalSubject;
use App\Mail\AccessCredentials;
use App\Models\CoAuthor;
use App\Models\JournalCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Journals extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $subjects;
    public $categories;
    
    public $signupModal = false;
    public $filters = false;
    public $journal;

    public $search_user;
    public $user;
    public $users = [];
    public $selectedSubjects = [];
    public $selectedCategories = [];

    public function mount()
    {
    }

    public function render()
    {
        $this->subjects   = JournalSubject::all();
        $this->categories = JournalCategory::all();
        
        $data = Journal::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%')->orWhere('description', 'ilike', '%' . $this->query . '%')->orWhere('publisher', 'ilike', '%' . $this->query . '%');
            });
        })->when($this->selectedSubjects, function ($query) {

            $query->whereIn('journal_subject_id', $this->selectedSubjects);

        })->when($this->selectedCategories, function ($query) {

            $query->whereIn('journal_category_id', $this->selectedCategories);

        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $journals = $data->paginate(5);

        return view('livewire.backend.journals', compact('journals'));
    }


    public function createJournal()
    {
        return redirect()->route('journals.create');
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

    public function confirmAssign(Journal $journal)
    {
        $this->record = $journal;
        $this->openDrawer();
    }


    public function searchUser($string)
    {
        $this->search_user = $string;
        $this->users = User::when($this->search_user, function ($query) {
            return $query->where(function ($query) {
                $query->where('first_name', 'ilike', '%' . $this->search_user . '%')->orWhere('middle_name', 'ilike', '%' . $this->search_user . '%')->orWhere('last_name', 'ilike', '%' . $this->search_user . '%');
            });
        })->limit('10')->get();
    }

    public function assignEditor(User $user)
    {
        $check = $user->journal_us()->where('journal_id', $this->record->id)->first();
        
        if(!$check->hasRole('Chief Editor')){
            $check->assignRole('Chief Editor');

            if(ReviewMessage::where('category', 'Assign Chief Editor')->count() > 0){
                Mail::to('mrenatuskiheka@yahoo.com')
                    ->send(new EditorialTeam($this->record, $check, 'Assign Chief Editor'));
            }

            session()->flash('response',[
                'status'  => '', 
                'message' => 'This user is successfully assigned as Chief Editor to this Journal'
            ]);
        }else{
            session()->flash('response',[
                'status'  => '', 
                'message' => 'This user is already having Chief Editors Previledges on this Journal'
            ]);
        }
        
        $this->closeDrawer();
    }

    public $isOpen = false;

    public function openDrawer()
    {
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }


    public $create = false;

    public function createnew($status)
    {
        $this->create = $status;
    }

    public $first_name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    public function getPassword($length = 8) {
        $upperCase    = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerCase    = 'abcdefghijklmnopqrstuvwxyz';
        $numbers      = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
    
        $allCharacters = $upperCase . $lowerCase . $numbers . $specialChars;
    
        $password = '';
        $max = strlen($allCharacters) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $allCharacters[random_int(0, $max)];
        }
    
        return $password;
    }

    public function createUser()
    {
        $this->validate(
            [
                'first_name'  => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name'   => 'required|string',
                'gender'      => 'required',
                'email'       => 'required|email|unique:users',
                'phone'       => 'nullable|string',
            ]
        );

        $password = $this->getPassword(8);
        $data  = new User;

        $data->first_name    = $this->first_name;
        $data->middle_name   = $this->middle_name;
        $data->last_name     = $this->last_name;
        $data->gender        = $this->gender;
        $data->email         = $this->email;
        $data->phone         = $this->phone;
        $data->password      = Hash::make($password);
        $data->added         = 1;
        $data->save();

        $data->journal_us()->create([
            'journal_id' => $this->record->id,
            'user_id'    => $data->id
        ]);

        if(!($data->journal_us()->where('journal_id', $this->record->id)->exists())){
            $data->journal_us()->attach($this->record->id);
        }
        
        $user = $data->journal_us()->where('journal_id', $this->record->id)->first();
        $user->assignRole('Chief Editor');

        if(ReviewMessage::where('category', 'Assign Chief Editor')->count() > 0){
            Mail::to('mrenatuskiheka@yahoo.com')
                ->send(new EditorialTeam($this->record, $user, 'Assign Chief Editor'));
        }

        if(ReviewMessage::where('category', 'Access Credentials')->count() > 0){
            Mail::to('mrenatuskiheka@yahoo.com')
                ->send(new AccessCredentials($this->record, $user, $password, 'Access Credentials'));
        }

        $this->closeDrawer();
        session()->flash('response', [
            'status'  => 'success', 
            'message' => 'User is created and successfully assigned to this journal'
        ]);

    }

    public function removeUser(JournalUser $user)
    {
        if($user->removeRole('Chief Editor')){
            session()->flash('response',[
                'status'  => 'success', 
                'message' => 'This user is successfully revoked as Chief Editor from this Journal'
            ]);
        }
    }


















    public function loadJournals(){
        set_time_limit(300);

        ini_set('max_execution_time', 300);
        $file = File::get('storage/journals_ajfm.json');

        $journals = json_decode($file);

        foreach($journals->getJournals as $journal){

            $the_journal = Journal::updateOrCreate([
                'code' => $journal->code
            ],[
                'title'     => $journal->title,
                'code'      => $journal->code,
                'doi'       => $journal->doi,
                'issn'      => $journal->issn,
                'eissn'     => $journal->eissn,
                'description' => $journal->description,
                'scope'     => $journal->scope,
                'year'      => $journal->year,
                'email'     => $journal->code.'@ifm.ac.tz',
                'user_id'   => auth()->user()->id,
                'image'     => $journal->image
            ]);

            foreach($journal->volumes as $key => $volume)
            {
                $volumex = Volume::updateOrCreate([
                    'number' => $volume->volume_number,
                    'journal_id' => $the_journal->id
                ],[
                    'number'      => $volume->volume_number,
                    'description' => 'Volume '.$volume->volume_number,
                    'journal_id'  => $the_journal->id,
                    'status'      => 'Closed'
                ]);

                foreach($volume->issues as $key => $issue)
                {
                    Issue::updateOrCreate([
                        'number'        => $issue->IssueNumber,
                        'volume_id'     => $volumex->id,
                        'journal_id'    => $the_journal->id
                    ],[
                        'number'        => $issue->IssueNumber,
                        'description'   => 'Issue '.$issue->IssueNumber,
                        'journal_id'    => $the_journal->id,
                        'volume_id'     => $volumex->id,
                        'publication'   => 'Published',
                        'publication_date' => $issue->DatePublished,
                        'status'        => 'Closed'
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
                    

                    $volume = Volume::firstOrCreate([
                        'number' => $article->volume->VolumeNumber,
                        'journal_id' => $the_journal->id
                    ],[
                        'number' => $article->volume->VolumeNumber,
                        'description' => 'Volume '.$article->volume->VolumeNumber,
                        'journal_id'  => $the_journal->id
                    ]);



                    $issue = Issue::firstOrCreate([
                        'number'     => $article->issue->IssueNumber,
                        'volume_id'  => $volume->id,
                        'journal_id' => $the_journal->id
                    ],[
                        'number'     => $article->issue->IssueNumber,
                        'volume_id'  => $volume->id,
                        'journal_id' => $the_journal->id,
                        'status'     => 'Closed',
                        'publication'      => 'Published',
                        'publication_date' => $issue->DatePublished,
                    ]);


                    $status = ArticleStatus::where('code', '006')->first();
                    $articx = Article::updateOrCreate([
                        'title'             => $article->article_title,
                        'journal_id'        => $the_journal->id,
                    ],[
                        'title'             => $article->article_title,
                        'abstract'          => $article->abstract,
                        'article_type_id'   => $article_type->id,
                        'journal_id'        => $the_journal->id,
                        'keywords'          => str_replace(';', ',', $article->keywords),
                        'areas'             => $article->areas,
                        'article_status_id' => $status->id,
                        'user_id'           => 1,
                        'volume_id'         => $volume->id,
                        'issue_id'          => $issue->id,
                        'publication_date'  => $issue->DatePublished,
                        'manuscript_file'   => $article->manuscript_file,
                        'country_id'        => 100
                    ]);
                    


                    foreach($article->authors as $key => $author){
                        $salutation = Salutation::firstOrCreate([
                            'title'=> $article->salutation
                        ],[
                            'title'=> $article->salutation
                        ]);
    
                        $gender = 'Male';
                        if($author->Title == 'Mr'){
                            $gender = 'Male';
                        }
    
                        if($author->Title == 'Ms'){
                            $gender = 'Female';
                        }


                        if($author->Email != ''){
                            $email = $author->Email;

                            $user = User::firstOrCreate([
                                'email'=> $email
                            ],[
                                'email'         => $email,
                                'first_name'    => $author->FName,
                                'middle_name'   => $author->MName,
                                'last_name'     => str_replace('*', ',', $author->LName),
                                'gender'        => $gender,
                                'salutation_id' => $salutation->id,
                                'password'      => Hash::make('154IFM@#_journal'),
                                'affiliation'   => $author->Affiliation,
                                'added'         => 1
                            ]);

                            $journal_user = $user->journal_us()->where('journal_id', $the_journal->id);
                            if($journal_user->count() == 0){
                                $journal_user = $user->journal_us()->create([
                                    'journal_id' => $the_journal->id,
                                    'can_review' => 0
                                ]);
                            }else{
                                $journal_user = $journal_user->first();
                            }
    
                            $journal_user->assignRole('Author');
                            
                            $uthor_no = 0;
                            if($author->Email != ''){
                                $articx->update([
                                    'user_id' => $user->id
                                ]);
    
                                $uthor_no = 1;
                            }
    
                            $articx->article_journal_users()->sync([$journal_user->id => ['number' => $uthor_no]], false);
                        }else{
                            CoAuthor::updateOrCreate([
                                'first_name'    => $author->FName,
                                'middle_name'   => $author->MName,
                                'last_name'     => str_replace('*', '', $author->LName),
                                'article_id'    => $articx->id
                            ],[
                                'first_name'    => $author->FName,
                                'middle_name'   => $author->MName,
                                'last_name'     => str_replace('*', '', $author->LName),
                                'affiliation'   => $author->Affiliation,
                                'salutation_id' => $salutation->id,
                                'article_id'    => $articx->id
                            ]);
                        }
                        
                    }
                }
            }
        }
    }

}
