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
    public $category = 'external';
    public $pf_number;

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
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();
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
            'pf_number'   => 'nullable|required_if:category,internal|string',
            'first_name'  => 'nullable|required_if:category,external|string',
            'middle_name' => 'nullable|string',
            'last_name'   => 'nullable|required_if:category,external|string',
            'gender' => 'required_if:category,external',
            'phone'  => 'nullable|string',
            'email'  => 'nullable|required_if:category,external|email',
            'password'  => [
                'sometimes',
                'nullable',
                'required_if:category,external',
                'confirmed',
                'min:6',
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
            'pf_number'     => $this->pf_number,
            'salutation_id' => $this->salutation,
            'password'      => Hash::make($this->password)
        ]);

        //$password = Hash::make($this->password);
        // $data->save();

        $review = 0;
        if(isset($this->can_review)){
            $review = 1;
        }
        
        if($data->journal_us()->where('journal_id', $this->journal->id)->count() == 0){
            $data->journal_us()->create([
                'journal_id' => $this->journal->id,
                'can_review' => $review
            ]);
        }
        

        $data->assignRole('Author');

        if(ReviewMessage::where('category', 'Journal Account')->count() > 0){
            Mail::to('mrenatuskiheka@yahoo.com')
                ->send(new JournalAccount($this->journal, $data));
        }

        session()->flash('success', 'Your Account is Successifully Created login with the email and password you provided');

        return redirect(route('login', $this->journal->uuid));
    }


    public function checkUser()
    {
        if(User::where('email', $this->email)->where('added', 0)->exists()){
            $this->user_check = 'exists';
        }else{
            $this->user_check = 'nouser';
        }
    }

    public function enrollConfirmation()
    {
        //$user = User::where('email', $this->email)->first();
        Mail::to('mrenatuskiheka@yahoo.com')
            ->send(new JournalAccount($this->journal, $user));
        
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
    
            Mail::to($this->email)
                ->send(new JournalAccount($this->journal, $user));
            
            session()->flash('success', 'You are successfully registered as an author on this journal');
        }else{
            session()->flash('error', 'No user record found registered with this email on this journal');
        }

    
    }

}
