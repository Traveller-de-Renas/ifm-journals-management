<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $Add;
    public $Edit;
    public $Delete;
    public $View;

    public $record;
    public $name;
    public $description;
    public $status;
    public $permission;
    public $role;
    
    public $roles;
    
    public function render()
    {
        $permissions  =  Permission::with('roles')->when($this->query, function($query){
            return $query->where(function($query){
                $query->where('name', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $permissions = $permissions->paginate(20);

        return view('livewire.backend.permissions', compact('permissions'));
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

    public function confirmEdit(Permission $data)
    {
        $this->record = $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->status = $data->status;

        $this->Edit = true;
    }

    public function confirmView(Permission $data)
    {
        $this->roles = Role::all()->pluck('name', 'id')->toArray();

        $this->permission = $data;
        $this->record = $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->status = $data->status;

        $this->View = true;
    }

    public function confirmDelete(Permission $data)
    {
        $this->record = $data->id;
        $this->Delete = true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function store()
    {
        $this->validate();
        // $array = array('', 'View ', 'Add ', 'Edit ', 'Delete ');
        // foreach($array as $permission){
            $data = Permission::create([
                'name' => $this->name
            ]);

            $data->assignRole('Administrator');
        // }

        $this->Add = false;
        return redirect()->back()->with('success', 'Saved Successifully!');
    }

    public function update(Permission $data)
    {
        $this->validate();
        $data->update([
            'name' => $this->name,
        ]);

        $this->Edit = false;
        return redirect()->back()->with('success', 'Updated Successifully!');
    }

    public function delete(Permission $data)
    {
        if($data->delete()){
            $this->Delete = false;
            return redirect()->back()->with('success', 'Deleted Successifully!');
        }
    }

    public function assign_role(Permission $data)
    {
        $role = Role::find($this->role);
        if($data->hasRole($role))
        {
            session()->flash('message', 'Role Exists');
        }else{
            $data->assignRole($role);
            session()->flash('message', 'Role Assigned Successifully');
        }
    }

    public function remove_role(Role $data)
    {
        if($this->permission->hasRole($data))
        {
            $this->permission->removeRole($data);
            session()->flash('message', 'Role Revoked Successifully');
        }else{
            session()->flash('message', 'Role does not Exists');
        }
    }
}
