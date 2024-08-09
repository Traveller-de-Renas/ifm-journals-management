<?php

namespace App\Livewire\Frontend;

use App\Models\Journal;
use Livewire\Component;
use App\Models\SlidingImage;

class Home extends Component
{
    public $query;
    public $search;
    public $all_journals = [];

    public function render()
    {
        $sliding_image = SlidingImage::where('status', 1)->orderBy('order', 'ASC')->get();
        $journals = Journal::where('status', 1)->orderBy('id', 'DESC')->limit(4)->get();

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
            })->orderBy('title', 'ASC')->get();
        }
    }
}
