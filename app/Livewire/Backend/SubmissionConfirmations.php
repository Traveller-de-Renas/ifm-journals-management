<?php

namespace App\Livewire\Backend;

use App\Models\SubmissionConfirmation;
use Livewire\Component;

class SubmissionConfirmations extends Component
{
    public $Delete = false;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $code;
    public $description;
    public $status;

    public function render()
    {
        $confirmations = SubmissionConfirmation::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('description', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $confirmations = $confirmations->paginate(20);
        return view('livewire.backend.submission-confirmations', compact('confirmations'));
    }

    public function store()
    {
        $this->validate([
            'code' => 'required',
            'description' => 'required'
        ]);

        SubmissionConfirmation::create([
            'code' => $this->code,
            'description' => $this->description
        ]);

        session()->flash('response', [
            'status'  => 'success', 
            'message' => 'Article submission conformation is created successifully'
        ]);
    }

    public function edit(SubmissionConfirmation $data)
    {
        $this->record = $data;
        $this->code = $data->code;
        $this->description = $data->description;

        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate([
            'code' => 'required',
            'description' => 'required'
        ]);

        $this->record->update([
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status
        ]);

        $this->isOpen = false;

        session()->flash('response', [
            'status'  => 'success', 
            'message' => 'Article submission confirmation is updated successifully'
        ]);
    }

    public function confirmDelte(SubmissionConfirmation $data)
    {
        $this->record = $data;
        $this->Delete = true;
    }

    public function delete()
    {
        if($this->record->delete()){
            session()->flash('response', [
                'status'  => 'success', 
                'message' => 'Article submission confirmation is deleted successifully'
            ]);
        }
    }

    public $roles;
    public $isOpen = false;

    public function openDrawer()
    {
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }
}
