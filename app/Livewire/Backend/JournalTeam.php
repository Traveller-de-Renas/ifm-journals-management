<?php

namespace App\Livewire\Backend;

use App\Mail\AccessCredentials;
use App\Models\User;
use App\Models\Journal;
use Livewire\Component;
use App\Mail\EditorialTeam;
use App\Models\JournalUser;
use App\Models\ReviewMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class JournalTeam extends Component
{
    public $journal;
    public $associate_editor = false;
    public $supporting_editor = false;

    public function render()
    {
        $journal_id = session()->get('journal');

        $this->journal = Journal::where('uuid', $journal_id)->first();
        return view('livewire.backend.journal-team');
    }

    public $first_name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

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
            $data  = new User;

            $data->first_name    = $this->first_name;
            $data->middle_name   = $this->middle_name;
            $data->last_name     = $this->last_name;
            $data->gender        = $this->gender;
            $data->email         = $this->email;
            $data->phone         = $this->phone;
            $data->password      = Hash::make($password);
            $data->added         = 1;

            $data->save();

            $data->journal_us()->create([
                'journal_id' => $this->journal->id,
                'user_id'    => $data->id
            ]);


            if(!($data->journal_us()->where('journal_id', $this->journal->id)->exists())){
                $data->journal_us()->attach($this->journal->id);
            }
            

            if($this->associate_editor){
                $user = $data->journal_us()->where('journal_id', $this->journal->id)->first();
                $user->assignRole('Associate Editor');

                if(ReviewMessage::where('category', 'Add Associate Editor')->count() > 0){
                    Mail::to($data->email)
                        ->send(new EditorialTeam($this->journal, $user, 'Add Associate Editor'));
                }

                if(ReviewMessage::where('category', 'Access Credentials')->count() > 0){
                    Mail::to($data->email)
                        ->send(new AccessCredentials($this->journal, $user, $password, 'Access Credentials'));
                }
            }


            if($this->supporting_editor){
                $user = $data->journal_us()->where('journal_id', $this->journal->id)->first();
                $user->assignRole('Supporting Editor');

                if(ReviewMessage::where('category', 'Add Supporting Editor')->count() > 0){
                    Mail::to('mrenatuskiheka@yahoo.com')
                        ->send(new EditorialTeam($this->journal, $user, $password, 'Add Supporting Editor'));
                }
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
                    'user_id'    => $this->user->id
                ]);
            }

            if($this->associate_editor){
                $user = $this->user->journal_us()->where('journal_id', $this->journal->id)->first();
                $user->assignRole('Associate Editor');
            }

            if($this->supporting_editor){
                $user = $this->user->journal_us()->where('journal_id', $this->journal->id)->first();
                $user->assignRole('Supporting Editor');
            }

            $this->closeDrawer();

            session()->flash('response',[
                'status'  => 'success', 
                'message' => 'This user is successfully assigned to this journal'
            ]);
        }

    }

    public function removeUser(JournalUser $user)
    {
        if($user->delete()){
            session()->flash('response',[
                'status'  => 'success', 
                'message' => 'This user is successfully removed from this journal'
            ]);
        }
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

    public function createnew($status)
    {
        $this->create = $status;
    }

    public $roles;
    public $isOpen = false;

    public function openDrawer()
    {
        $this->isOpen = true;
    }

    public function closeDrawer()
    {
        $this->isOpen = false;
    }
}
