<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class Users extends Component
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
    public $name;
    public $status;
    public $gender;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    public $role;
    public $permission;

    public $roles;
    public $permissions;
    
    public function render()
    {
        $users = User::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('name', 'ilike', '%'.$this->query.'%')->orWhere('email', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
        
        $users = $users->paginate(20);
        return view('livewire.backend.users', compact('users'));
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

    public function confirmEdit(User $data)
    {
        $this->record = $data->id;
        $this->name = $data->name;
        $this->status = $data->status;

        $this->Edit = true;
    }

    public function confirmDelete(User $data)
    {
        $this->record = $data->id;
        $this->Delete = true;
    }

    public function confirmView(User $user)
    {
        $this->user = $user;

        $roles = Role::all();
        $permissions = Permission::all();

        $data_roles = array();
        foreach($roles as $value){
            $data_roles[$value->name] = $value->name;
        }
        $this->roles = $data_roles;

        $data_perm = array();
        foreach($permissions as $value){
            $data_perm[$value->name] = $value->name;
        }
        $this->permissions = $data_perm;
        
        $this->View = true;
    }

    public function rules()
    {
        return [
            'name'   => 'required|string',
            'gender' => 'required',
            'phone'  => 'nullable|string',
            'email'  => 'required|email|unique:users',
            'password'  => [
                'sometimes',
                'nullable',
                'required',
                'confirmed',
                'min:6',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/'
            ],
        ];
    }

    public function store()
    {
        $this->validate();
        $data = new User;
        $data->create([
            'name'     => $this->name,
            'gender'   => $this->gender,
            'email'    => $this->email,
            'phone'    => $this->phone,
            'status'   => $this->status,
            'password' => Hash::make($this->password),
        ]);
        
        session()->flash('success', 'Saved Successifully');
        $this->Add = false;
    }

    public function update(User $data)
    {
        $this->validate();
        $data->update([
            'name'   => $this->name,
            'gender' => $this->gender,
            'email'  => $this->email,
            'phone'  => $this->phone,
            'status' => $this->status,
            'password' => Hash::make($this->password),
        ]);
        
        session()->flash('success', 'Updated Successifully');
        $this->Edit = false;
    }

    public function delete(User $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
        }
    }

    public function assign_role()
    {
        if($this->user->hasRole($this->role))
        {
            return response()->json(['message'=>'Role Exists']);
        }else{
            $this->user->assignRole($this->role);
            return response()->json(['message'=>'Role Assigned Successifully']);
        }
    }

    public function remove_role(Role $role)
    {
        if($this->user->hasRole($role))
        {
            $this->user->removeRole($role);
            return response()->json(['message'=>'Role Removed Successifully']);
        }else{
            return response()->json(['message'=>'Role does not Exists']);
        }
    }


    public function grant_permission()
    {
        if($this->user->hasPermissionTo($this->permission))
        {
            return response()->json(['message'=>'Permission Already Exists']);
        }else{
            $this->user->givePermissionTo($this->permission);
            return response()->json(['message'=>'Permission Granted Successifuly']);
        }
    }


    public function revoke_permission(Permission $permission)
    {
        if($this->user->hasPermissionTo($permission))
        {
            $this->user->revokePermissionTo($permission);
            return response()->json(['message'=>'Permission Revoked Successifully']);
        }else{
            return response()->json(['message'=>'Permission does not Exists']);
        }
    }
}
