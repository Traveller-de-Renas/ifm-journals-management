<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
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
    
    public $permissions;
    
    public function render()
    {
        $roles  =  Role::with('permissions')->when($this->query, function($query){
            return $query->where(function($query){
                $query->where('name', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $roles = $roles->paginate(20);

        return view('livewire.backend.roles', compact('roles'));
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

    public function confirmEdit(Role $data)
    {
        $this->record = $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->status = $data->status;

        $this->Edit = true;
    }

    public function confirmView(Role $data)
    {
        $this->permissions = Permission::all()->pluck('name', 'id')->toArray();
        
        $this->role = $data;
        $this->record = $data->id;
        $this->name = $data->name;

        $this->View = true;
    }

    public function confirmDelete(Role $data)
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
        $data = Role::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Saved Successifully');
        $this->Add = false;
    }

    public function update(Role $data)
    {   
        $this->validate();
        $data->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Updated Successifully');
        $this->Edit = false;
    }

    public function delete(Role $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
        }
    }

    public function give_permission(Role $data)
    {
        $permission = Permission::find($this->permission);
        if($data->hasPermissionTo($permission))
        {
            session()->flash('message', 'Role Exists');
        }else{
            $data->givePermissionTo($permission);
            session()->flash('message', 'Role Assigned Successifully');
        }
    }

    public function remove_permission(Permission $data)
    {
        if($this->role->hasPermissionTo($data))
        {
            $this->role->revokePermissionTo($data);
            session()->flash('message', 'Role Revoked Successifully');
        }else{
            session()->flash('message', 'Role does not Exists');
        }
    }
}
