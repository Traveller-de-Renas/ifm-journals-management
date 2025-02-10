<?php

namespace App\Livewire\Frontend;

use App\Models\Journal;
use App\Models\JournalSubject;
use Livewire\Component;
use App\Models\JournalCategory;
use Illuminate\Support\Facades\Auth;

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

            $query->whereIn('subject_id', $this->selectedSubjects);

        })->when($this->selectedCategories, function ($query) {

            $query->whereIn('category_id', $this->selectedCategories);

        })->whereHas('journal_us', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Chief Editor']);
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $data = $data->paginate(5);

        return view('livewire.frontend.journals', compact('data'));
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
}
