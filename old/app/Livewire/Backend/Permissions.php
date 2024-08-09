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
        $array = array('', 'View ', 'Add ', 'Edit ', 'Delete ');
        foreach($array as $permission){
            $data = Permission::create([
                'name' => $permission.$this->name
            ]);

            $data->assignRole('Administrator');
        }

        session()->flash('success', 'Saved Successifully');
        $this->Add = false;
    }

    public function update(Permission $data)
    {   
        $this->validate();
        $data->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Updated Successifully');
        $this->Edit = false;
    }

    public function delete(Permission $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
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
