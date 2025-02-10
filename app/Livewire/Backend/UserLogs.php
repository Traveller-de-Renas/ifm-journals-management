<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class UserLogs extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $Add;
    public $Edit;
    public $Delete;
    public $View;

    public $user;
    public $record;
    
    public function render()
    {
        $users = Activity::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('description', 'ilike', '%'.$this->query.'%')->orWhere('event', 'ilike', '%'.$this->query.'%')->orWhere('properties', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $users = $users->paginate(20);
        return view('livewire.backend.user_logs', compact('users'));
    }

    public function sort($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmDelete(Activity $data)
    {
        $this->record = $data->id;
        $this->Delete = true;
    }

    public function confirmView(Activity $user)
    {
        $this->user = $user;
        
        $this->View = true;
    }

    public function delete(Activity $data)
    {
        if($data->delete()){
            $this->Delete = false;
            return redirect()->back()->with('success', 'Deleted Successifully!');
        }
    }
}
