<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Category;
use App\Models\JournalIndex;
use App\Models\JournalInstruction;
use App\Models\SubmissionConfirmation;

class Journals extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $Add;
    public $Edit;
    public $Delete;

    public $record;
    public $title;
    public $code;
    public $image;
    public $status;
    public $category;
    public $description;
    public $year;
    public $publisher;
    public $issn;
    public $eissn;
    public $email;
    public $website;
    public $scope;

    public $instruction_title = [];
    public $instruction_description = [];
    public $confirmation_description = [];

    public $index_title = [];
    public $index_description = [];
    public $index_link = [];

    public $form = false;
    public $subjects;
    public $categories;
    public $panel;
    public $indecies = [''];
    public $confirmations = [''];
    public $instructions = [''];

    public function mount()
    {
        
    }

    public function render()
    {
        $this->subjects = Subject::all();
        $this->categories = Category::all()->pluck('name', 'id')->toArray();

        $journals = Journal::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%')->orWhere('description', 'ilike', '%' . $this->query . '%')->orWhere('publisher', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $journals = $journals->paginate(20);

        return view('livewire.backend.journals', compact('journals'));
    }

    public function store()
    {

        $this->validate([
            'title'       => 'required',
            'image'       => 'nullable|file|max:4024|mimes:jpg,png,JPG,PNG',
            'code'        => 'required',
            'category'    => 'required',
            'status'      => 'required',
            'description' => 'required',
        ]);

        if($this->image){
            $file  = $this->image;
            $_name = $file->getClientOriginalName();
            $_type = $file->getClientOriginalExtension();
            $_file = str_replace(' ', '_', $_name);

            $file->storeAs('public/journals/', $_file);
        }

        $journal = Journal::create([
            'title'       => $this->title,
            'code'        => $this->code,
            'issn'        => $this->issn,
            'eissn'       => $this->eissn,
            'category_id' => $this->category,
            'status'      => $this->status,
            'description' => $this->description,
            'scope'       => $this->scope,
            'year'        => $this->year,
            'publisher'   => $this->publisher,
            'email'       => $this->email,
            'website'     => $this->website,
        ]);

        foreach($this->instruction_title as $key => $instruction)
        {
            JournalInstruction::create([
                'title' => $instruction,
                'description' => $this->instruction_description[$key],
                'journal_id' => $journal->id
            ]);
        }

        foreach($this->confirmation_description as $key => $description)
        {
            SubmissionConfirmation::create([
                'description' => $description,
                'journal_id' => $journal->id
            ]);
        }

        foreach($this->index_title as $key => $index)
        {
            JournalIndex::create([
                'title' => $index,
                'description' => $this->index_description[$key],
                'link' => $this->index_description[$key],
                'journal_id' => $journal->id
            ]);
        }

        $this->form = false;
        $this->reset();
    }

    public function view_panel($panel)
    {
        if($this->panel == $panel){
            $this->panel = '';
        }else{
            $this->panel = $panel;
        }
    }

    public function addRows($x)
    {
        $this->$x[] = '';
    }

    public function removeRows($index, $x)
    {
        unset($this->$x[$index]);
    }

}
