<?php

namespace App\Livewire\Backend;

use App\Models\Issue;
use App\Models\Volume;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use App\Models\ArticleStatus;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PublicationProcess extends Component
{
    use WithFileUploads;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $record;
    public $status;
    public $deleteModal = false;
    public $journal;

    public function render()
    {
        $journal  = Journal::where('uuid', session('journal'))->first();
        $this->journal = $journal;

        $volumes = $journal->volumes()->when($this->query, function ($query, $search) {
                return $query->where(function($query){
                    $query->where('number', 'ilike', '%'.$this->query.'%')->orWhere('description', 'ilike', '%'.$this->query.'%');
                });
            })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $volumes = $volumes->paginate(20);



        $status = ArticleStatus::whereIn('code', ['011', '014'])->get()->pluck('id')->toArray();
        $this->articles = $journal->articles()->when($this->search_manuscript, function ($query, $search) {
            return $query->where(function($query){
                $query->where('title', 'ilike', '%'.$this->search_manuscript.'%');
            });
        })
        ->where('user_id', '<>', auth()->user()->id)
        ->where('issue_id', '=', null)
        ->whereIn('article_status_id', $status)
        ->get();

        return view('livewire.backend.publication-process', compact('volumes'));
    }


    public $volumeMod = false;
    public function volumeModal()
    {
        $this->volumeMod = true;
    }

    public $issueMod = false;
    public function issueModal(Issue $issue)
    {
        $this->issue = $issue;
        $this->issueMod = true;
    }


    public function createVolume()
    {
        $number = $this->journal->volumes()->count() + 1;
        Volume::create([
            'number' => $number,
            'journal_id' => $this->journal->id,
            'description' => 'Volume '.$number
        ]);

        session()->flash('response',[
            'status'  => '', 
            'message' => 'Manuscript is Saved and Submitted successfully'
        ]);

    }

    


    public function createIssue(Volume $volume, $category)
    {
        if($category == 'normal'){
            $volume->issues()->create([
                'number' => $volume->issues()->count() + 1,
                'description' => 'Issue '.($volume->issues()->count() + 1),
                'journal_id' => $this->journal->id,
                'status' => 'Pending',
            ]);
        }

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'New Issue is Created successfully on this volume'
        ]);
    }


    public $isOpen   = false;
    public $volume;
    public $svolumes = [];
    public $articles;
    public $search_manuscript;
    public $issue;

    public function openDrawer(Issue $issue)
    {
        $this->issue = $issue;
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }


    public $isOpenA   = false;

    public function openDrawerA(Issue $issue)
    {
        $this->dispatch('contentChanged');
        $this->issue = $issue;
        $this->isOpenA = true;
    }

    public function closeDrawerA()
    {
        $this->isOpenA = false;
    }


    public $selected_articles = [];
    public function assignManuscript()
    {
        foreach($this->selected_articles as $article_id){
            $paper = Article::find($article_id);

            $paper->volume_id = $this->issue->volume_id;
            $paper->issue_id  = $this->issue->id;
            $paper->save();
        }

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Manuscripts successfully assigned on this issue for publication'
        ]);
    }


    public function publishIssue(Issue $issue)
    {
        $this->issue->publication      = 'Published';
        $this->issue->publication_date = now();
        
        $this->issue->save();

        $status = ArticleStatus::where('code', '014')->first();

        Article::query()
            ->where('volume_id', $issue->volume_id)
            ->where('issue_id', $issue->id)
            ->update([
                'article_status_id' => $status->id,
                'publication_date'  => now()
            ]);

        $this->issueMod = false;

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'Manuscripts successfully assigned on this issue for publication'
        ]);
    }

    public $editorial;
    public $editorial_file;

    public function submitEditorial()
    {
        $this->validate([
            'editorial_file' => 'required|file|max:14024|mimes:pdf',
        ]);

        $file  = $this->editorial_file;
        $file->storeAs('editorial/', $this->issue->uuid.'.pdf');

        $this->issue->editorial = $this->editorial;
        $this->issue->editorial_file = $this->issue->uuid.'.pdf';

        $this->issue->update();

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'Editorial successfully uploaded on this issue'
        ]);
    }


    public function removeEditorial()
    {
        if (Storage::exists('editorial/'.$this->issue->editorial_file)) {
            Storage::delete('editorial/'.$this->issue->editorial_file);

            $this->issue->editorial = null;
            $this->issue->editorial_file = null;

            $this->issue->update();

            session()->flash('response',[
                'status'  => 'success',
                'message' => 'Editorial Review is successfully removed on this issue'
            ]);
        }else{
            session()->flash('response',[
                'status'  => 'success',
                'message' => 'Failed to remove the Editorial Review File does not Exist'
            ]);
        }
    }
}
