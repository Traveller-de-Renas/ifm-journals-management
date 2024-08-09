<?php

namespace App\Livewire\Backend;

use App\Models\Subject;
use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $name;
    public $subject;

    public $form = false;
    public $subjects;

    public function mount()
    {
        $this->subjects = Subject::all()->pluck('name', 'id')->toArray();
    }
    public function render()
    {
        $categories = Category::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('name', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $categories = $categories->paginate(20);
        return view('livewire.backend.categories', compact('categories'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'subject' => 'required',
        ]);

        Category::create([
            'name' => $this->name,
            'subject_id' => $this->subject,
        ]);

        $this->form = false;
        $this->reset();
    }

    public function edit(Category $category)
    {
        $this->form = true;
        $this->record = $category;
    }

    public function update(Category $category)
    {
        $this->validate([
            'name' => 'required',
            'subject' => 'required',
        ]);

        $category->update([
            'name' => $this->name,
            'subject_id' => $this->subject,
        ]);

        $this->form = false;
        $this->reset();
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
