<?php

namespace App\Livewire\Backend;

use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleDetails extends Component
{
    public $record;
    public $tab = 'taba';
    
    public function mount(Request $request){
        if(!Str::isUuid($request->article)){
            abort(404);
        }
        
        $this->record = Article::where('uuid', $request->article)->first();
        if(empty($this->record)){
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.backend.article-details');
    }
}
