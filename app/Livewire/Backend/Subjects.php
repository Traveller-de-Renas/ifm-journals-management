<?php

namespace App\Livewire\Backend;

use App\Models\JournalSubject;
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
        $subjects = JournalSubject::when($this->query, function ($query) {
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

        JournalSubject::create([
            'name' => $this->name,
        ]);

        $this->form = false;
        $this->reset();
    }

    public function edit(JournalSubject $subject)
    {
        $this->form = true;
        $this->record = $subject;
    }

    public function update(JournalSubject $subject)
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

    public function destroy(JournalSubject $subject)
    {
        $subject->delete();
    }
}
