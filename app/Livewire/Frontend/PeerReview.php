<?php

namespace App\Livewire\Frontend;

use App\Models\Issue;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;

class PeerReview extends Component
{
    public $journals_count;
    public $issues_count;
    public $articles_count;

    public function render()
    {
        $journals = Journal::where('status', 1)->whereHas('journal_us', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Chief Editor']);
            });
        });
        
        $this->journals_count = $journals->count();

        
        $this->issues_count   = Issue::where('publication', 'Published')->count();
        $this->articles_count = Article::whereHas('article_status', function ($query) { 
            $query->where('code', '014'); 
        })->count();

        $journals = $journals->orderBy('id', 'DESC')->limit(6)->get();
        
        return view('livewire.frontend.peer-review', compact('journals'));
    }
}
