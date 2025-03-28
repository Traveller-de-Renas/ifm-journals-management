<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\EditorChecklist;
use App\Models\EditorialProcess;

class EditorChecklists extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $description;
    public $code;
    public $status;
    public $editorial_process;


    public function render()
    {
        $editorial_processes = EditorialProcess::where('status', 1)->get();
        $checklists = EditorChecklist::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('description', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $checklists = $checklists->paginate(20);

        return view('livewire.backend.editor-checklists', compact('checklists', 'editorial_processes'));
    }

    public function store()
    {
        $this->validate([
            'description' => 'required',
            'editorial_process' => 'required'
        ]);

        EditorChecklist::create([
            'description' => $this->description,
            'code' => $this->code,
            'editorial_process_id' => $this->editorial_process
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'New Editor Checklist Item is created successfully'
        ]);

        $this->reset();
        $this->closeDrawer();
    }

    public function edit(EditorChecklist $data)
    {
        $this->openDrawer();
        
        $this->record = $data;
        $this->description = $data->description;
        $this->code = $data->code;
        $this->editorial_process = $data->editorial_process_id;
    }

    public function update()
    {
        $this->validate([
            'description' => 'required',
            'editorial_process' => 'required'
        ]);

        $this->record->update([
            'description' => $this->description,
            'code' => $this->code,
            'editorial_process_id' => $this->editorial_process
        ]);

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Editor Checklist Item is updated successfully'
        ]);

        $this->reset();
        $this->closeDrawer();
    }

    public function destroy(EditorChecklist $data)
    {
        $this->record = $data;
    }

    public function delete()
    {
        $this->record->delete();

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Editor Checklist Item is deleted successfully'
        ]);
    }


    public $isOpen = false;

    public function openDrawer()
    {
        // $this->dispatch('contentChanged');
        $this->record = null;
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }


    public $isOpenA = false;

    public function openDrawerA(EditorChecklist $data)
    {
        $this->record  = $data;
        $this->isOpenA = true;
    }

    public function closeDrawerA()
    {
        $this->isOpenA = false;
    }
}
