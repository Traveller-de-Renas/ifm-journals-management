<?php

namespace App\Livewire\Backend;

use App\Models\Journal;
use Livewire\Component;

class EditorGuide extends Component
{
    public $journal;
    
    public function render()
    {
        $journal_id = session()->get('journal');

        $this->journal = Journal::where('uuid', $journal_id)->first();

        return view('livewire.backend.editor-guide');
    }
}
