<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;
use App\Models\CallForPaper;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CallForPapers extends Component
{
    use WithFileUploads;
    
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $deleteModal;

    public $record;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $image;
    public $category;
    public $journal;
    public $subjects;

    public function mount()
    {
        $this->journal = Journal::where('uuid', session('journal'))->first();
    }
    
    public function render()
    {
        $this->dispatch('contentChanged');

        $call = CallForPaper::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $call = $call->paginate(20);
        return view('livewire.backend.call-for-papers', compact('call'));
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'journal' => 'required',
            'description' => 'required',
        ]);

        $file      = $this->image;
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $savename  = rand('100', '999').str_replace(' ', '_', $file_name);
        $file->storeAs('call_for_papers/', $savename);

        CallForPaper::create([
            'title'         => $this->title,
            'description'   => $this->description,
            'category'      => $this->category,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'user_id'       => auth()->user()->id,
            'journal_id'    => $this->journal->id,
            'image'         => $savename
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'You successfully created a new call for papers for this Journal'
        ]);

        $this->reset();
    }

    public function edit(CallForPaper $call)
    {
        $this->record       = $call;
        $this->title        = $call->title;
        $this->description  = $call->description;
        $this->start_date   = $call->start_date;
        $this->end_date     = $call->end_date;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'journal' => 'required',
            'description' => 'required',
        ]);

        if(Storage::exists('call_for_papers/'.$this->record?->image)){
            Storage::delete('call_for_papers/'.$this->record?->image);
        }

        $file      = $this->image;
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $savename  = rand('100', '999').str_replace(' ', '_', $file_name);
        $file->storeAs('call_for_papers/', $savename);

        $this->record->update([
            'title'         => $this->title,
            'description'   => $this->description,
            'category'      => $this->category,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'journal_id'    => $this->journal->id,
            'image'         => $savename
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'You successfully updated this call for papers'
        ]);

        $this->reset();
    }

    public function confirmDelete(CallForPaper $call)
    {
        $this->record      = $call;
        $this->deleteModal = true;
    }

    public function destroy()
    {
        $this->record->delete();

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'You successfully deleted this call for papers'
        ]);
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
}
