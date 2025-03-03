<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;
use App\Models\ArticleStatus;

class Dashboard extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;

    public $currentJournal;

    public function render()
    {
        $statuses = ArticleStatus::whereNotIn('code', ['001', '004', '005', '007', '012', '014', '015', '016', '018', '019', '020'])->get();

        $data = Journal::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%')->orWhere('description', 'ilike', '%' . $this->query . '%')->orWhere('publisher', 'ilike', '%' . $this->query . '%');
            });
        })->with('articles', function ($query) use ($statuses) {
            $status = $statuses->pluck('id')->toArray();
            return $query->whereIn('article_status_id', $status);
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $journals = $data->paginate(5);

        return view('livewire.backend.dashboard', compact('journals','statuses'));
    }

    public function setJournal($currentJournal)
    {
        $this->currentJournal = $currentJournal;
    }
}
