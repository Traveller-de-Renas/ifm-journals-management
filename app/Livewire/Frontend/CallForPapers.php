<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\CallForPaper;

class CallForPapers extends Component
{
    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false;
    
    public function render()
    {
        $call = CallForPaper::when($this->query, function ($query) {
            return $query->where(function ($query) {
                $query->where('title', 'ilike', '%' . $this->query . '%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $call = $call->paginate(20);
        return view('livewire.frontend.call-for-papers', compact('call'));
    }
}
