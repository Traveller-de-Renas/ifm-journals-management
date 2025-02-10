<?php

namespace App\Livewire\Backend;

use App\Models\FileCategory;
use Livewire\Component;

class FileCategories extends Component
{
    public $Delete = false;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $name;
    public $code;
    public $description;
    public $submitted;

    public function render()
    {
        $categories = FileCategory::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('name', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $categories = $categories->paginate(20);
        return view('livewire.backend.file-categories', compact('categories'));
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'description' => 'required',
            'submitted' => 'required'
        ]);

        FileCategory::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'submitted' => $this->submitted
        ]);

        session()->flash('response', [
            'status'  => 'success', 
            'message' => 'File category for article submission is created successifully'
        ]);
    }

    public function edit(FileCategory $category)
    {
        $this->record = $category;
        $this->name = $category->name;
        $this->code = $category->code;
        $this->description = $category->description;
        $this->submitted = $category->submitted;

        $this->isOpen = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'description' => 'required',
            'submitted' => 'required'
        ]);

        $this->record->update([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'submitted' => $this->submitted
        ]);

        $this->isOpen = false;

        session()->flash('response', [
            'status'  => 'success', 
            'message' => 'File category for article submission is created successifully'
        ]);
    }

    public function confirmDelte(FileCategory $category)
    {
        $this->record = $category;
        $this->Delete = true;
    }

    public function delete()
    {
        if($this->record->delete()){
            session()->flash('response', [
                'status'  => 'success', 
                'message' => 'File category for article submission is deleted successifully'
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
