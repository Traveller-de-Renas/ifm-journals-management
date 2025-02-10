<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\ReviewMessage;

class ReviewMessages extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $description;
    public $category;

    public function render()
    {
        $messages = ReviewMessage::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('description', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $messages = $messages->paginate(20);

        return view('livewire.backend.review-messages', compact('messages'));
    }

    public function store()
    {
        $this->validate([
            'description' => 'required',
            'category' => 'required'
        ]);

        ReviewMessage::create([
            'description' => $this->description,
            'category' => $this->category,
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'New Message is created successfully'
        ]);

        $this->reset();
        $this->closeDrawer();
    }

    public function edit(ReviewMessage $data)
    {
        $this->openDrawer();
        
        $this->record      = $data;
        $this->description = $data->description;
        $this->category    = $data->category;
    }

    public function update()
    {
        $this->validate([
            'description' => 'required',
            'category' => 'required'
        ]);

        $this->record->update([
            'description' => $this->description,
            'category' => $this->category
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Message is successfully updated'
        ]);

        $this->reset();
        $this->closeDrawer();
    }

    public function destroy(ReviewMessage $data)
    {
        $this->record = $data;
    }

    public function delete()
    {
        $this->record->delete();

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Message is successfully removed'
        ]);
    }


    public $isOpen = false;

    public function openDrawer()
    {
        $this->dispatch('contentChanged');
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }


    public $isOpenA = false;

    public function openDrawerA(ReviewMessage $data)
    {
        $this->record  = $data;
        $this->isOpenA = true;
    }

    public function closeDrawerA()
    {
        $this->isOpenA = false;
    }
}
