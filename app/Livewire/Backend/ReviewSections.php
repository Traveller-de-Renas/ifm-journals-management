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
    public $query_confidential = [];

    public $saved_query_title = [];
    public $saved_option_title = [];
    public $saved_query_confidential = [];

    public $category;
    public $section_options = [''];
    public $queries = [''];

    public $saved_queries;
    public $saved_section_options;

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

        $data = ReviewSection::create([
            'title' => $this->title,
            'category' => $this->category
        ]);

        if(isset($this->option_title)){
            foreach ($this->option_title as $key => $value) {
                ReviewSectionOption::create([
                    'review_section_id' => $data->id,
                    'title' => $value
                ]);
            }
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

    public function confirmEdit(ReviewSection $review_section)
    {
        $this->record = $review_section;

        $this->title = $review_section->title;
        $this->category = $review_section->category;

        $this->saved_section_options = $review_section->reviewSectionOption;
        $this->saved_queries = $review_section->reviewSectionQuery;

        foreach ($this->saved_section_options as $key => $value) {
            $this->saved_option_title[$key] = $value->title;
        }

        foreach ($this->saved_queries as $key => $value) {
            $this->saved_query_title[$key] = $value->title;
            $this->saved_query_confidential[$key] = $value->confidential;
        }

        $this->form = true;

    }

    public function updateRow($key, $category)
    {
        if($category == 'section_options')
        {
            if($this->saved_section_options[$key]->update([
                'title' => $this->saved_option_title[$key]
            ])){
                session()->flash('success', 'Saved successfully');
            }
        }

        if($category == 'queries')
        {
            if($this->saved_queries[$key]->update([
                'title' => $this->saved_query_title[$key],
                'confidential' => $this->saved_query_confidential[$key]
            ])){
                session()->flash('success', 'Saved successfully');
            }
        }
    }

    public function deleteRow()
    {

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

    public function update()
    {
        $this->validate([
            'title'    => 'required',
            'category' => 'required',
        ]);

        $this->record->title    = $this->title;
        $this->record->category = $this->category;
        $this->record->update();

        if(isset($this->option_title)){
            $this->record->reviewSectionOption()->delete();

            foreach ($this->option_title as $key => $value) {
                ReviewSectionOption::create([
                    'review_section_id' => $this->record->id,
                    'title' => $value
                ]);
            }
        }

        foreach ($this->query_title as $key => $value) {
            $this->record->reviewSectionQuery()->delete();

            ReviewSectionQuery::create([
                'review_section_id' => $this->record->id,
                'title' => $value
            ]);
        }

        session()->flash('success', 'Updated successfully');
        $this->form = false;
    }

    public function checkCategory($category)
    {
        $this->category = $category;
    }
}
