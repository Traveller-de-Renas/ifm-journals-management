<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use App\Models\JournalUser;
use Illuminate\Support\Facades\Hash;

class JournalUsers extends Component
{
    public $journal;

    public function render()
    {   
        $this->salutations = Salutation::where('status', 1)->pluck('title', 'id')->toArray();
        $journal_id = session()->get('journal');

        $this->journal = Journal::where('uuid', $journal_id)->first();
        return view('livewire.backend.journal-users');
    }

    public $first_name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $email;
    public $phone;
    public $salutation;
    public $salutations;

    public function getPassword($length = 8) {
        $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers   = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
    
        $allCharacters = $upperCase . $lowerCase . $numbers . $specialChars;
    
        $password = '';
        $max = strlen($allCharacters) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $allCharacters[random_int(0, $max)];
        }
    
        return $password;
    }

    public function store()
    {
        if($this->create){
            $this->validate(
                [
                    'first_name'  => 'required|string',
                    'middle_name' => 'nullable|string',
                    'last_name'   => 'required|string',
                    'gender'      => 'required',
                    'email'       => 'required|email|unique:users',
                    'phone'       => 'nullable|string',
                ]
            );

            $password = $this->getPassword(8);
            $data     = new User;

            $data->first_name    = $this->first_name;
            $data->middle_name   = $this->middle_name;
            $data->last_name     = $this->last_name;
            $data->gender        = $this->gender;
            $data->email         = $this->email;
            $data->phone         = $this->phone;
            $data->password      = Hash::make($password);
            $data->added         = 1;
            $data->salutation_id = $this->salutation;
            $data->affiliation   = $this->affiliation;

            $data->save();

            $data->journal_us()->create([
                'journal_id' => $this->journal->id,
                'status'     => 1,
                'user_id'    => $data->id
            ]);


            if(!($data->journal_us()->where('journal_id', $this->journal->id)->exists())){
                $data->journal_us()->attach($this->journal->id);
            }


            $this->closeDrawer();

            session()->flash('response', [
                'status'  => 'success', 
                'message' => 'User is created and successfully assigned to this journal'
            ]);

        }else{

            if(!($this->user->journal_us()->where('journal_id', $this->journal->id)->exists())){
                $this->user->journal_us()->create([
                    'journal_id' => $this->journal->id,
                    'status'     => 1,
                    'user_id'    => $this->user->id
                ]);
            }

            $this->closeDrawer();

            session()->flash('response',[
                'status'  => 'success', 
                'message' => 'This user is successfully assigned to this journal'
            ]);
        }

    }

    public function updateMember()
    {
        $this->validate(
            [
                'first_name'  => 'required|string',
                'middle_name' => 'nullable|string',
                'last_name'   => 'required|string',
                'gender'      => 'required',
                'email'       => 'required|email|unique:users,email,'.$this->user->id,
                'phone'       => 'nullable|string',
            ]
        );

        $this->user->first_name    = $this->first_name;
        $this->user->middle_name   = $this->middle_name;
        $this->user->last_name     = $this->last_name;
        $this->user->gender        = $this->gender;
        $this->user->email         = $this->email;
        $this->user->phone         = $this->phone;
        $this->user->salutation_id = $this->salutation;
        $this->user->affiliation   = $this->affiliation;

        $this->user->update();

        $this->closeDrawer();

        session()->flash('response',[
            'status'  => 'success', 
            'message' => 'Journal User Information is successfully updated'
        ]);
    }


    public function removeUser(JournalUser $user)
    {
        $user->syncRoles(['Author']);
        
        session()->flash('response',[
            'status'  => 'success',
            'message' => 'This user is successfully removed from this journal'
        ]);
    }


    public $search_user;
    public $username;
    public $users = [];
    public $user;

    public function searchUser($string)
    {
        $this->search_user = $string;
        $this->users = User::when($this->search_user, function ($query) {
            return $query->where(function ($query) {
                $query->where('first_name', 'ilike', '%' . $this->search_user . '%')->orWhere('middle_name', 'ilike', '%' . $this->search_user . '%')->orWhere('last_name', 'ilike', '%' . $this->search_user . '%');
            });
        })->limit('10')->get();
    }

    public function selectUser(User $user)
    {
        $this->username = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
        $this->user = $user;
        $this->users = [];
    }

    public $create = false;
    public $update = false;

    public function createnew($status)
    {
        $this->create = $status;
    }

    public function updateInfo(User $user)
    {
        $this->user         = $user;
        $this->first_name   = $user->first_name;
        $this->middle_name  = $user->middle_name;
        $this->last_name    = $user->last_name;
        $this->gender       = $user->gender;
        $this->email        = $user->email;
        $this->phone        = $user->phone;
        $this->affiliation  = $user->affiliation;
        $this->salutation   = $user->salutation_id;

        $this->create  = true;
        $this->isOpen  = true;
        $this->update  = true;
    }

    public $record;
    public $isOpen = false;

    public function openDrawer()
    {
        $this->isOpen  = true;
    }

    public function closeDrawer()
    {
        $this->record  = null;
        $this->isOpen  = false;
    }

    public $affiliation;
    public $affiliations = [];

    public function checkAffiliation()
    {
        $this->affiliations = User::whereLike('affiliation', '%'.$this->affiliation.'%')->groupBy('affiliation')
        ->get(['affiliation']);

    }


    public function selectAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;
    }
}
