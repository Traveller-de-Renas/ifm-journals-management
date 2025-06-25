<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use App\Models\JournalUser;
use Illuminate\Support\Str;
use App\Mail\JournalAccount;
use Illuminate\Http\Request;
use App\Models\ReviewMessage;
use App\Mail\AccountActivation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Register extends Component
{
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
    public $password;
    public $password_confirmation;

    public $journal;
    public $countries;
    public $salutations;
    public $user_check;
    public $can_review;

    public function mount(Request $request){
        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->journal = Journal::where('uuid', $request->journal)->first();
        if(empty($this->journal)){
            abort(404);
        }

        $this->countries = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::where('status', 1)->pluck('title', 'id')->toArray();
    }

    public function render()
    {
        if($this->email){
            $this->checkUser();
        }
        return view('livewire.auth.register');
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
            'affiliation' => 'required|string',
            'password'    => [
                'sometimes',
                'nullable',
                'required',
                'confirmed',
                'min:8',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/'
            ],
        ];
    }

    public function store()
    {
        $this->validate();

        $data = User::updateOrCreate([
            'email'=> $this->email
        ],[
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
            'password'      => Hash::make($this->password)
        ]);

        $review = 0;
        if(isset($this->can_review)){
            $review = 1;
        }

        $journal_user = $data->journal_us()->where('journal_id', $this->journal->id);
        
        if($journal_user->count() == 0){
            $journal_user = $data->journal_us()->create([
                'journal_id' => $this->journal->id,
                'can_review' => $review,
            ]);

            $journal_user->assignRole('Author');
        }

        session()->flash('success', 'You are successfully registered as new author on this journal to proceed with to the submission portal please activate your account through the link sent to your email address.');

        if(ReviewMessage::where('category', 'Journal Account')->count() > 0){
            Mail::to($this->email)
                ->send(new JournalAccount($this->journal, $data));
        }

        $this->accountActivationLink($data);
    }


    public function checkUser()
    {
        if(User::where('email', $this->email)->where('added', 0)->exists()){
            $this->user_check = 'exists';
        }else{
            $this->user_check = 'nouser';
        }
    }

    public function accountActivationLink($user)
    {
        if(ReviewMessage::where('category', 'Account Activation')->count() > 0){
            Mail::to($user->email)
                ->send(new AccountActivation($this->journal, $user));
        }
        
    }


    public function enroll()
    {
        $this->validate([
            'email' => 'email|required'
        ]);

        $user = User::where('email', $this->email)->first();

        if(!empty($user)){
            $review = 0;
            if(isset($this->can_review)){
                $review = 1;
            }

            $journal_us = JournalUser::firstOrCreate([
                'user_id'    => $user->id,
                'journal_id' => $this->journal->id
            ],[
                'user_id'    => $user->id,
                'journal_id' => $this->journal->id,
                'can_review' => $review
            ]);

            if(!($journal_us->hasRole('Author'))){
                $journal_us->assignRole('Author');
            }

            if(ReviewMessage::where('category', 'Journal Account')->count() > 0){
                Mail::to($this->email)
                    ->send(new JournalAccount($this->journal, $user));
            }

            $this->accountActivationLink($user);
            
            session()->flash('success', 'You are successfully registered as new author on this journal to proceed with to the submission portal please activate your account through the link sent to your email address.');
        }else{
            session()->flash('error', 'No user record found registered with this email on this journal');
        }
    
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
