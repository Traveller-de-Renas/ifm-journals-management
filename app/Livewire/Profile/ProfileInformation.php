<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProfileInformation extends Component
{
    public $journal;

    public $record;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $status;
    public $gender;
    public $email;
    public $phone;
    public $salutation;
    public $country;
    public $degree;
    public $interests;
    public $biography;
    public $password;
    public $password_confirmation;
    public $affiliation;
    public $affiliations = [];

    public $countries;
    public $salutations;
    public $can_review;

    public function mount()
    {
        $this->record       = auth()->user();
        if(!$this->record->hasRole('Administrator'))
        {
            if(!Str::isUuid(session('journal'))){
                abort(404);
            }
            
            $this->journal = Journal::where('uuid', session('journal'))->first();
            if(empty($this->journal)){
                abort(404);
            }
        }
        
        
        $this->first_name   = $this->record->first_name;
        $this->middle_name  = $this->record->middle_name;
        $this->last_name    = $this->record->last_name;
        $this->gender       = $this->record->gender;
        $this->email        = $this->record->email;
        $this->phone        = $this->record->phone;
        $this->salutation   = $this->record->salutation_id;
        $this->country      = $this->record->country_id;
        $this->degree       = $this->record->degree;
        $this->interests    = $this->record->interests;
        $this->affiliation  = $this->record->affiliation;
        $this->biography    = $this->record->biography;

    }

    public function render()
    {
        $this->countries   = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::where('status', 1)->pluck('title', 'id')->toArray();
        
        return view('livewire.profile.profile-information');
    }

    public function rules()
    {
        return [
            'first_name'  => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name'   => 'required|string',
            'gender'      => 'required',
            'phone'       => 'nullable|string',
            'email'       => 'required|email',
            'affiliation' => 'required|string'
        ];
    }

    public function update()
    {
        $this->validate();

        $this->record->update([
            'first_name'    => $this->first_name,
            'middle_name'   => $this->middle_name,
            'last_name'     => $this->last_name,
            'gender'        => $this->gender,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'degree'        => $this->degree,
            'interests'     => $this->interests,
            'country_id'    => $this->country,
            'salutation_id' => $this->salutation,
            'affiliation'   => $this->affiliation,
            'biography'     => $this->biography
        ]);

        if(!$this->record->hasRole('Administrator'))
        {
            $review = 0;
            if(isset($this->can_review)){
                $review = 1;
            }

            $journal_user = $this->record->journal_us()->where('journal_id', $this->journal->id);
            
            if($journal_user->count() == 0){
                $journal_user = $this->record->journal_us()->create([
                    'journal_id' => $this->journal->id,
                    'can_review' => $review,
                ]);

                $journal_user->assignRole('Author');
            }
        }

        session()->flash('response',[
            'status'  => 'success',
            'message' => 'Your profile is successifully updated'
        ]);
    }

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
