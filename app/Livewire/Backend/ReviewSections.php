<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReviewSection;
use App\Models\ReviewSectionQuery;
use App\Models\ReviewSectionOption;

class ReviewSections extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $View;
    public $deleteModal = false;

    public $record;
    public $title;
    public $query_title = [];
    public $option_title = [];
    public $category;
    public $section_options = [''];
    public $queries = [''];

    public $form = false;

    public function mount()
    {
    }
    
    public function render()
    {
        $review_sections = ReviewSection::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('title', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $review_sections = $review_sections->paginate(20);
        return view('livewire.backend.review-sections', compact('review_sections'));
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'category' => 'required',
        ]);

        $data =ReviewSection::create([
            'title' => $this->title,
            'category' => $this->category
        ]);

        foreach ($this->option_title as $key => $value) {
            ReviewSectionOption::create([
                'review_section_id' => $data->id,
                'title' => $value
            ]);
        }

        foreach ($this->query_title as $key => $value) {
            ReviewSectionQuery::create([
                'review_section_id' => $data->id,
                'title' => $value
            ]);
        }

        session()->flash('success', 'Saved successfully');
        $this->form = false;
    }

    public function edit(ReviewSection $review_section)
    {
        $this->form = true;
        $this->record = $review_section;
    }

    public function confirmDelete(ReviewSection $review_section)
    {
        $this->deleteModal = true;
        $this->record = $review_section;
    }

    public function delete(ReviewSection $review_section)
    {
        $this->deleteModal = false;
        $this->record = '';
    }

    public function addRows($x)
    {
        $this->$x[] = '';
    }

    public function removeRow($index, $x)
    {
        unset($this->$x[$index]);
    }

    public function checkCategory($category)
    {
        
    }
}
