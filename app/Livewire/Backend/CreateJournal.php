<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;
use App\Models\ArticleType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\JournalSubject;
use App\Models\AuthorGuideline;
use App\Models\JournalCategory;

class CreateJournal extends Component
{
    use WithFileUploads;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $Add;
    public $Edit;
    public $Delete;

    public $record, $title, $code, $image, $status, $category, $description, $year, $publisher, $doi, $issn, $eissn, $email, $website, $scope, $editor_guide, $author_guide;

    public $instruction_title = [];
    public $instruction_description = [];
    public $confirmation_description = [];

    public $type_name = [];
    public $type_description = [];

    public $subjects;
    public $categories;
    public $article_types = [''];
    public $instructions = [''];


    public function mount(Request $request)
    {
        
        if(!Str::isUuid($request->journal) && $request->journal != ''){
            abort(404);
        }

        if($request->journal != ''){
            $this->record = Journal::where('uuid', $request->journal)->first();
            if(empty($this->record) && $request->journal != 'create'){
                abort(404);
            }

            $this->edit($this->record);
        }
        
        $this->dispatch('contentChanged');
    }


    public function render()
    {
        $this->subjects   = JournalSubject::all();
        $this->categories = JournalCategory::all()->pluck('name', 'id')->toArray();

        return view('livewire.backend.create-journal');
    }

    public function store()
    {
        $this->validate([
            'title'       => 'required',
            'image'       => 'nullable|max:4024|mimes:jpg,png,JPG,PNG',
            'author_guide' => 'nullable|max:4024|mimes:pdf',
            'editor_guide' => 'nullable|max:4024|mimes:pdf',
            'code'        => 'required',
            'category'    => 'required',
            'status'      => 'required',
        ]);


        $journal = new Journal;

        if($this->image){
            $file  = $this->image;
            $_name = $file->getClientOriginalName();
            $_type = $file->getClientOriginalExtension();
            $_file = str_replace(' ', '_', $_name);

            $file->storeAs('public/journals/', $_file);

            $journal->image = $_file;
        }


        if($this->author_guide){
            $file_ag  = $this->author_guide;
            $_name_ag = $file_ag->getClientOriginalName();
            $_type = $file_ag->getClientOriginalExtension();
            $_file_ag = str_replace(' ', '_', $_name_ag);

            $file_ag->storeAs('public/journals/', $_file_ag);

            $journal->author_guide = $_file_ag;
        }


        if($this->editor_guide){
            $file_eg  = $this->editor_guide;
            $_name_eg = $file_eg->getClientOriginalName();
            $_type = $file_eg->getClientOriginalExtension();
            $_file_eg = str_replace(' ', '_', $_name_eg);

            $file_eg->storeAs('public/journals/', $_file_eg);

            $journal->editor_guide = $_file;
        }

        
        $journal->title     = $this->title;
        $journal->code      = $this->code;
        $journal->doi       = $this->doi;
        $journal->issn      = $this->issn;
        $journal->eissn     = $this->eissn;
        $journal->journal_category_id = $this->category;
        $journal->status    = $this->status;
        $journal->description = $this->description;
        $journal->scope     = $this->scope;
        $journal->year      = $this->year;
        $journal->publisher = $this->publisher;
        $journal->email     = $this->email;
        $journal->website   = $this->website;
        $journal->user_id   = auth()->user()->id;

        $journal->save();

        foreach($this->instruction_title as $key => $instruction)
        {
            AuthorGuideline::create([
                'title' => $instruction,
                'description' => $this->instruction_description[$key],
                'journal_id'  => $journal->id
            ]);
        }

        if($this->type_name){

            foreach($this->type_name as $key => $type)
            {
                ArticleType::create([
                    'name' => $type,
                    'description' => $this->type_description[$key],
                    'journal_id' => $journal->id
                ]);
            }

        }else{
            $article_types = [
                'Original Article',
                'Review Article',
                'Case Study',
                'Methodology',
                'Other'
            ];

            foreach($article_types as $key => $type)
            {
                ArticleType::create([
                    'name' => $type,
                    'description' => $type,
                    'journal_id' => $journal->id
                ]);
            }
        }


        session()->flash('response',[
            'status'  => 'success',
            'message' => 'New Journal is created successfully'
        ]);

        $this->reset();
    }

    public function update(Journal $journal)
    {
        $this->validate([
            'title'    => 'required',
            'code'     => 'required',
            'category' => 'required',
            'status'   => 'required',
        ]);

        try {

            if($this->image){
                $file  = $this->image;
                $_name = $file->getClientOriginalName();
                $_type = $file->getClientOriginalExtension();
                $_file = str_replace(' ', '_', $_name);

                $file->storeAs('journals/', $_file);

                $journal->image = $_file;
            }

            if($this->author_guide){
                $file_ag  = $this->author_guide;
                $_name_ag = $file_ag->getClientOriginalName();
                $_type = $file_ag->getClientOriginalExtension();
                $_file_ag = str_replace(' ', '_', $_name_ag);

                $file_ag->storeAs('journals/', $_file_ag);

                $journal->author_guide = $_file_ag;
            }

            if($this->editor_guide){
                $file_eg  = $this->editor_guide;
                $_name_eg = $file_eg->getClientOriginalName();
                $_type = $file_eg->getClientOriginalExtension();
                $_file_eg = str_replace(' ', '_', $_name_eg);

                $file_eg->storeAs('journals/', $_file_eg);

                $journal->editor_guide = $_file_eg;
            }
            
            $journal->title     = $this->title;
            $journal->code      = $this->code;
            $journal->doi       = $this->doi;
            $journal->issn      = $this->issn;
            $journal->eissn     = $this->eissn;
            $journal->journal_category_id  = $this->category;
            $journal->status       = $this->status;
            $journal->description  = $this->description;
            $journal->scope     = $this->scope;
            $journal->year      = $this->year;
            $journal->publisher = $this->publisher;
            $journal->email     = $this->email;
            $journal->website   = $this->website;

            $journal->update();

            if(!empty($this->instruction_title)){
                AuthorGuideline::where('journal_id', $journal->id)->delete();
                foreach($this->instruction_title as $key => $instruction)
                {
                    $ins = new AuthorGuideline;
                    
                    if($instruction != null){
                        $ins->title         = $instruction;
                        $ins->description   = (isset($this->instruction_description[$key]))? $this->instruction_description[$key] : null;
                        $ins->journal_id    = $journal->id;
                        $ins->save();
                    }
                    
                }
            }
            

            if(!empty($this->type_name)){
                ArticleType::where('journal_id', $journal->id)->delete();
                foreach($this->type_name as $key => $type)
                {
                    $typ = new ArticleType;
                    
                    if($type != null){
                        $typ->name         = $type;
                        $typ->description  = (isset($this->type_description[$key]))? $this->type_description[$key] : null;
                        $typ->journal_id   = $journal->id;
                        $typ->save();
                    }
                }
            }else{
                $article_types = [
                    'Original Article',
                    'Review Article',
                    'Case Study',
                    'Methodology',
                    'Other'
                ];

                foreach($article_types as $key => $type)
                {
                    ArticleType::create([
                        'name' => $type,
                        'description' => $type,
                        'journal_id' => $journal->id
                    ]);
                }
            }


            session()->flash('response',[
                'status'  => 'success',
                'message' => 'Journal has been updated successfully!'
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Some Errors Occured: ' . $e->getMessage());
        }
    }

    public function edit(Journal $journal)
    {
        $this->record      = $journal;
        $this->title       = $journal->title;
        $this->code        = $journal->code;
        $this->status      = $journal->status;
        $this->category    = $journal->journal_category_id;
        $this->description = $journal->description;
        $this->year        = $journal->year;
        $this->publisher   = $journal->publisher;
        $this->doi         = $journal->doi;
        $this->issn        = $journal->issn;
        $this->eissn       = $journal->eissn;
        $this->email       = $journal->email;
        $this->website     = $journal->website;
        $this->scope       = $journal->scope;

        if($this->record->instructions){
            foreach($this->record->instructions as $key => $ins){
                $this->instructions[] = '';

                $this->instruction_title[$key] = $ins->title;
                $this->instruction_description[$key] = $ins->description;
            }
        }

        if($this->record->article_types){
            foreach($this->record->article_types as $key => $ins){
                $this->article_types[] = '';

                $this->type_name[$key] = $ins->name;
                $this->type_description[$key] = $ins->description;
            }
        }

        
    }

    public $step = 1;

    public function incrementStep()
    {
        $this->step++;
    }

    public function decrementStep()
    {
        $this->step--;
    }

    public function setStep($step)
    {
        $this->step = $step;
        $this->dispatch('contentChanged');

    }

    public function addRows($x)
    {
        $this->$x[] = '';
        
    }

    public function removeRow($index, $x)
    {
        unset($this->$x[$index]);
    }
}
