<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class JournalDetails extends Component
{
    public $record;
    public $seditor;
    public $editor_search;
    public $editor_names;

    public function mount(Request $request){

        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->record = Journal::where('uuid', $request->journal)->first();
        if(empty($this->record)){
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.backend.journal-details');
    }

    public function searchEditor($string)
    {
        if($string != ''){
            $this->editor_search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            $this->editor_names = User::when($this->editor_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->editor_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->editor_search.'%')->orWhere('last_name', 'ilike', '%'.$this->editor_search.'%');
                });
            })->orderBy('first_name', 'ASC')->get();
        }
    }

    public function assignEditor(User $editor)
    {
        $this->seditor = '';

        $editor->journals()->sync([$this->record->id => ['role' => 'editor']]);

        //dd($this->record->id);
    }

    public function removeEditor(User $editor)
    {
        $editor->journals()->detach($this->record->id);

    }
}
