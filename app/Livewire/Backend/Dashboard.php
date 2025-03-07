<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\ArticleStatus;

class Dashboard extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $statux;
    public $currentJournal;
    public $journal;

    public function mount()
    {
        if(session('journal') != '' && Str::isUuid(session('journal'))){
            $this->journal = Journal::where('uuid', session('journal'))->first();
        }
    }

    public function render()
    {
        $statuses = ArticleStatus::whereNotIn('code', ['001', '004', '005', '007', '012', '014', '015', '016', '017', '018', '019', '020'])->orderBy('code', 'ASC')->get();

        $data = Journal::where('status', 1);

        if($this->journal){
            $data = $data->where('id', $this->journal->id);
        }

        $data = $data->when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%')->orWhere('description', 'ilike', '%' . $this->query . '%')->orWhere('publisher', 'ilike', '%' . $this->query . '%');
            });
        })->with('articles', function ($query) use ($statuses) {
            $status = $statuses->pluck('id')->toArray();

            if($this->statux){
                return $query->where('article_status_id', $this->statux);
            } else {
                return $query->whereIn('article_status_id', $status);
            }
            
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $journals = $data->paginate(5);

        return view('livewire.backend.dashboard', compact('journals','statuses'));
    }

    public function setJournal($currentJournal)
    {
        $this->statux = null;
        $this->currentJournal = $currentJournal;
    }

    public function filterArticles($journal, $status)
    {
        $this->statux = $status;
        $this->currentJournal = $journal;
    }
}
