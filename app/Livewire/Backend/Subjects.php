<?php

namespace App\Livewire\Backend;

use App\Models\Subject;
use Livewire\Component;

class Subjects extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $name;

    public $form = false;
    public function render()
    {
        $subjects = Subject::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('name', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $subjects = $subjects->paginate(20);
        return view('livewire.backend.subjects', compact('subjects'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        Subject::create([
            'name' => $this->name,
        ]);

        $this->form = false;
        $this->reset();
    }

    public function edit(Subject $subject)
    {
        $this->form = true;
        $this->record = $subject;
    }

    public function update(Subject $subject)
    {
        $this->validate([
            'name' => 'required',
        ]);

        $subject->update([
            'name' => $this->name,
        ]);

        $this->form = false;
        $this->reset();
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
    }
}
