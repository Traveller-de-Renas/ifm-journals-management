<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReviewSection;
use App\Models\ReviewSectionQuery;
use App\Models\ReviewSectionOption;
use App\Models\ReviewSectionsGroup;

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
    public $sub_title    = [];
    public $sections     = [];
    public $category     = [[]]; 

    public $option_title = [];
    public $options      = [[]];
    public $queries      = [[]];



    
    public $query_confidential = [];

    public $saved_query_title = [];
    public $saved_options = [];
    public $saved_query_confidential = [];

    public $saved_queries;
    public $saved_section_options;

    public $form = false;

    public function mount()
    {
        if($this->record != ''){
            $this->addRows('sections');
        }
        
    }
    
    public function render()
    {
        $review_sections = ReviewSectionsGroup::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('title', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $review_sections = $review_sections->paginate(20);
        return view('livewire.backend.review-sections', compact('review_sections'));
    }

    public function store()
    {

        $section_group = ReviewSectionsGroup::create([
            'title' => $this->title
        ]);

        foreach($this->sections as $skey => $section){

            $data = ReviewSection::create([
                'title'    => $this->sub_title[$skey],
                'category' => $this->category[$skey],
                'review_sections_group_id' => $section_group->id
            ]);


            if(isset($this->options[$skey])){
                foreach ($this->options[$skey] as $key => $value) {
                    ReviewSectionOption::create([
                        'review_section_id' => $data->id,
                        'title' => $value
                    ]);
                }
            }


            foreach ($this->queries[$skey] as $key => $value) {
                ReviewSectionQuery::create([
                    'review_section_id' => $data->id,
                    'title' => $value
                ]);
            }
        }
    
        

        session()->flash('success', 'Saved successfully');
        $this->form = false;
    }

    public function confirmEdit(ReviewSectionsGroup $review_section_group)
    {
        $this->record = $review_section_group;
        $this->title  = $review_section_group->title;

        // $this->sections = $review_section_group->reviewSections;



        foreach($review_section_group->reviewSections as $skey => $review_section)
        {
            $this->sections[$review_section->id]  = $review_section;
            $this->sub_title[$review_section->id] = $review_section->title;
            $this->category[$review_section->id]  = $review_section->category;

            foreach ($review_section->reviewSectionOption as $key => $value) {
                $this->options[$review_section->id][$value->id] = $value->title;
            }


            foreach ($review_section->reviewSectionQuery as $key => $value) {
                $this->queries[$review_section->id][$value->id] = $value->title;
            }

        }

       

        $this->form = true;

    }

    public function updateRow($key, $category)
    {
        if($category == 'section_options')
        {
            if($this->saved_section_options[$key]->update([
                'title' => $this->saved_options[$key]
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

    public function addRows($x, $key = null)
    {
        if($x == 'queries' || $x == 'options'){
            $this->$x[$key][] = '';

        }else if($x == 'sections'){
            $this->$x[] = '';
            $this->category[][] = '';
            $this->queries[][]  = '';
            $this->options[][]  = '';

        }else{
            $this->$x[] = '';
        }



        
    }

    public function removeRow($index, $x)
    {
        unset($this->$x[$index]);
    }

    public function update()
    {
        // $this->validate([
        //     'title'    => 'required',
        //     'category' => 'required',
        // ]);

        dd($this->sections);

        foreach($this->sections as $skey => $section){

            $data = ReviewSection::create([
                'title'    => $this->sub_title[$skey],
                'category' => $this->category[$skey],
                'review_sections_group_id' => $section_group->id
            ]);

            if(isset($this->options[$skey])){
                foreach ($this->options[$skey] as $key => $value) {
                    ReviewSectionOption::create([
                        'review_section_id' => $data->id,
                        'title' => $value
                    ]);
                }
            }

            foreach ($this->queries[$skey] as $key => $value) {
                ReviewSectionQuery::create([
                    'review_section_id' => $data->id,
                    'title' => $value
                ]);
            }
        }

        session()->flash('success', 'Updated successfully');
        $this->form = false;
    }

    public function checkCategory($category, $skey)
    {
        $this->category[$skey] = $category;
    }
}
