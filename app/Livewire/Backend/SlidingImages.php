<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\SlidingImage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class SlidingImages extends Component
{
    use WithPagination, WithFileUploads;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $Add;
    public $Edit;
    public $Delete;

    public $record;
    public $images;
    public $link;
    public $url;
    public $order;
    public $status;
    public $caption;

    public $links;

    public function render()
    {
        $sliding_images = SlidingImage::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('image', 'ilike', '%'.$this->query.'%')->orWhere('caption', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $sliding_images = $sliding_images->paginate(20);

        return view('livewire.backend.sliding-images', compact('sliding_images'));
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

    public function confirmEdit(SlidingImage $data)
    {
        $this->record  = $data->id;
        $this->caption = $data->caption;
        $this->url     = $data->url;
        $this->order   = $data->order;
        $this->status  = $data->status;

        $this->Edit = true;
    }

    public function confirmDelete(SlidingImage $data)
    {
        $this->record = $data->id;
        $this->Delete = true;
    }

    public function rules()
    {
        return [
            'images.*' => 'nullable|file|max:7024|mimes:jpg,png',
            'caption'  => 'nullable|string',
            'url'      => 'nullable|string',
            'order'    => 'nullable|integer',
        ];
    }

    public function store()
    {
        $this->validate();
        if($this->images){
            $images = $this->images;
    
            foreach ($images as $key => $file) {
                $file_name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                $savename  = str_replace(' ', '_', $file_name);

                $file->storeAs('/slider', $savename);

                $data = new SlidingImage;

                $data->image   = $savename;
                $data->caption = $this->caption;
                $data->url     = $this->url;
                $data->order   = $this->order;
                $data->status  = 1;

                $data->save();
            }
        }

        $this->reset([
            'images'
        ]);
        
        session()->flash('success', 'Saved Successifully');
        $this->Add = false;
    }

    public function update(SlidingImage $data)
    {
        if($this->images){
            $file = $this->images;

            $file_name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $savename  = str_replace(' ', '_', $file_name);

            $file->storeAs('/slider', $savename);

            $data->image = $savename;
        }

        $data->caption = $this->caption;
        $data->url     = $this->url;
        $data->order   = $this->order;
        $data->status  = $this->status;

        $data->update();

        $this->reset([
            'images'
        ]);
        
        session()->flash('success', 'Updated Successifully');
        $this->Edit = false;
    }

    public function delete(SlidingImage $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
        }
    }
}
