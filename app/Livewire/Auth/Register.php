<?php

namespace App\Livewire\Auth;

use App\Models\StaffList;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

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
    public $category = 'internal';
    public $pf_number;

    public function render()
    {
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
        
        $data->first_name  = $this->first_name;
        $data->middle_name = $this->middle_name;
        $data->last_name   = $this->last_name;
        $data->gender      = $this->gender;
        $data->email       = $this->email;
        $data->phone       = $this->phone;
        $data->degree      = $this->degree;
        $data->interests   = $this->interests;
        $data->country_id  = $this->country;
        $data->pf_number   = $this->pf_number;
        $data->salutation_id = $this->salutation;
        $data->password      = $password;

        if(empty($user)){
            $data->save();
        }else{
            $data->update();
        }
        
        session()->flash('success', $message);
        return redirect()->to('/login');
    }

    public function checkCategory($category)
    {
        //dd($category);
    }
}
