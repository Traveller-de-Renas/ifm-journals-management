<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;
use App\Models\Category;

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

    public $form = false;
    public $categories;
    public $panel;
    public $instructions = [''];

    public function mount()
    {
        
    }

    public function render()
    {
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
            'code'        => 'required',
            'category'    => 'required',
            'status'      => 'required',
            'description' => 'required',
        ]);

        $journal = Journal::create([
            'title'       => $this->title,
            'code'        => $this->code,
            'category_id' => $this->category,
            'status'      => $this->status,
            'description' => $this->description,
        ]);

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
