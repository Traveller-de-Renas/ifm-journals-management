<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\SocialMedia;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class SocialMedias extends Component
{
    use WithPagination, WithFileUploads;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $Add;
    public $Edit;
    public $Delete;

    public $record;
    public $name;
    public $link;
    public $icon;
    public $image;
    public $type;
    public $status;
    public $description;

    public $show = 'svg';

    public function render()
    {
        $social_medias = SocialMedia::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('name', 'ilike', '%'.$this->query.'%')->orWhere('link', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $social_medias = $social_medias->paginate(20);

        return view('livewire.backend.social-medias', compact('social_medias'));
    }

    public function sort($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmAdd()
    {
        $this->Add = true;
    }

    public function confirmEdit(SocialMedia $data)
    {
        $this->record = $data->id;
        $this->name = $data->name;
        $this->link = $data->link;
        $this->icon = $data->icon;
        $this->type = $data->type;
        $this->description = $data->description;
        $this->status = $data->status;

        $this->Edit = true;
    }

    public function confirmDelete(SocialMedia $data)
    {
        $this->record = $data->id;
        $this->Delete = true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string',
            'link'        => 'required|string',
            'icon'        => 'string',
            'image'       => 'file|max:4024|mimes:jpg,png',
            'description' => 'string',
            'type'        => 'required'
        ];
    }

    public function store()
    {
        $this->validate();
        $data = new SocialMedia;

        $savename = '';
        if($this->image){
            $file       = $this->image;
            $_name      = $file->getClientOriginalName();
            $extension  = $file->getClientOriginalExtension();
            $icon       = str_replace(' ', '_', $_name);

            $file->storeAs('public/social_media/', $icon);
        }else{
            $icon  = $this->icon;
        }

        $data->create([
            'name'          => $this->name,
            'link'          => $this->link,
            'icon'          => $icon,
            'type'          => $this->type,
            'description'   => $this->description,
            'status'        => $this->status,
        ]);
        
        session()->flash('success', 'Saved Successifully');
        $this->Add = false;
    }

    public function update(SocialMedia $data)
    {
        $this->validate();
        if($this->image){
            if (Storage::exists('public/social_media/'.$data->image)) {
                Storage::delete('public/social_media/'.$data->image);
            }

            $file       = $this->image;
            $_name      = $file->getClientOriginalName();
            $extension  = $file->getClientOriginalExtension();
            $icon       = str_replace(' ', '_', $_name);

            $file->storeAs('public/social_media/', $icon);
            $data->icon = $icon;
        }else{
            $data->icon = $this->icon;
        }

        $data->name         = $this->name;
        $data->link         = $this->link;
        $data->type         = $this->type;
        $data->description  = $this->description;
        $data->status       = $this->status;

        $data->update();
        
        session()->flash('success', 'Updated Successifully');
        $this->Edit = false;
    }

    public function delete(SocialMedia $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
        }
    }

    public function iconFX($value){
        $this->show = $value;
    }
}
