<?php

namespace App\Livewire\Frontend;

use App\Models\Issue;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use App\Models\SlidingImage;

class Home extends Component
{
    public $query;
    public $search;
    public $all_journals = [];
    
    public $journals_count;
    public $issues_count;
    public $articles_count;

    public function render()
    {
        $sliding_image = SlidingImage::where('status', 1)->orderBy('order', 'ASC')->get();
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
        return view('livewire.frontend.home', compact('sliding_image', 'journals'));
    }

    public function searchJournal($string)
    {
        if($string != ''){
            $new_string = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            
            $this->query = $new_string;
            $this->all_journals = Journal::when($this->query, function($query){
                return $query->where(function($query){
                    $query->where('title', 'ilike', '%'.$this->query.'%')->orWhere('code', 'ilike', '%'.$this->query.'%')->orWhere('description', 'ilike', '%'.$this->query.'%');
                });
            })->whereHas('journal_us', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['Chief Editor']);
                });
            })->orderBy('title', 'ASC')->get();
        }
    }
}
