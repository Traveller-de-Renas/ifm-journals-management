<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Models\StaffList;
use App\Models\Salutation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\JournalEnrollMail;
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
            'email'  => 'nullable|required_if:category,external|email|unique:users',
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
        $data  = new User;

        if($this->pf_number != null && $this->category == 'internal'){
            if(StaffList::where('pf_number', $this->pf_number)->first()){
                $staff = StaffList::find(StaffList::where('pf_number', $this->pf_number)->first()->id);
                $user  = (User::where('pf_number', $this->pf_number)->first())? User::find(User::where('pf_number', $this->pf_number)->first()->id) : null;

                $this->first_name   = $staff->first_name;
                $this->middle_name  = $staff->middle_name;
                $this->last_name    = $staff->last_name;
                $this->gender       = $staff->gender;
                $this->email        = $staff->email;
                $this->phone        = $staff->phone;
                $this->salutation   = $staff->salutation_id;
                $this->interests    = $staff->interests;
                $this->pf_number    = $staff->pf_number;
                $password           = $staff->password;
                
                if(empty($user)){
                    $message = 'Your Account is Successifully Created login with your EMS Username and Password';
                }else{
                    $data    = $user;
                    $message = 'Your Account already Exist login with your EMS Username and Password';
                }

            }else{
                session()->flash('error', 'Staff with this PF Number is Not Found');
                return;
            }
        }else{
            $password = Hash::make($this->password);
            $message  = 'Your Account is Successifully Created login with the email and password you provided';
        }
        
        $data->first_name    = $this->first_name;
        $data->middle_name   = $this->middle_name;
        $data->last_name     = $this->last_name;
        $data->gender        = $this->gender;
        $data->email         = $this->email;
        $data->phone         = $this->phone;
        $data->degree        = $this->degree;
        $data->interests     = $this->interests;
        $data->country_id    = $this->country;
        $data->pf_number     = $this->pf_number;
        $data->salutation_id = $this->salutation;
        $data->password      = $password;

        if(empty($user)){
            $data->save();
        }else{
            $data->update();
        }
        
        $data->journals()->sync([$this->journal->id => ['role' => 'author']]);

        session()->flash('success', $message);
        return redirect()->to('/login');
    }

    public function checkCategory($category)
    {
        //dd($category);
    }

    public function checkUser()
    {
        if(User::where('email', $this->email)->exists()){
            $this->user_check = 'exists';
        }else{
            $this->user_check = 'nouser';
        }
    }

    public function enrollConfirmation()
    {
        $user = User::where('email', $this->email)->first();
        Mail::to('mrenatuskiheka@yahoo.com')
            ->send(new JournalEnrollMail($this->journal, $user));
        
        session()->flash('success', 'A confirmation email is sent to the email you entered for enrollment confirmation on this journal');
    }


    public function enroll()
    {
        $this->validate([
            'email' => 'email|required'
        ]);

        $user = User::where('email', $this->email)->first();
        // Auth::user()->journal_users()->sync([$this->journal->id => ['role' => 'author']]);
        $user->journal_users()->attach([$this->journal->id => ['role' => 'author']]);
        
        session()->flash('success', 'You are successfully registered as an author on this journal');
    }



}
