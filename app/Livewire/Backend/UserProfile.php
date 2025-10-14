<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\JournalUser;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserProfile extends Component
{
    public $record;
    
    public function mount(Request $request){
        if(!Str::isUuid($request->user)){
            abort(404);
        }

        $this->record = User::where('uuid', $request->user)->first();
        if(empty($this->record)){
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.backend.user-profile');
    }


    public $journal_user;
    public $isOpen = false, $roles = [];
    public function showRoles(JournalUser $journal_user)
    {
        $this->journal_user = $journal_user;
        $this->roles        = Role::whereNotIn('name', $journal_user->roles()->pluck('name')->toArray())->get();
        $this->isOpen       = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
        $this->journal_user = null;
    }

    public function assignRoles(Role $role)
    {
        if($this->journal_user->hasRole($role))
        {
            return response()->json(['message'=>'Role Exists']);
        }else{
            $this->journal_user->assignRole($role);
            return response()->json(['message'=>'Role Assigned Successifully']);
        }
    }

    public function removeRoles(Role $role)
    {
        if($this->journal_user->hasRole($role))
        {
            $this->journal_user->removeRole($role);
            return response()->json(['message'=>'Role Removed Successifully']);
        }else{
            return response()->json(['message'=>'Role does not Exists']);
        }
    }
}
