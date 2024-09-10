<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Country;
use Livewire\Component;
use App\Models\Salutation;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $record;
    public $salutations = [];
    public $countries = [];
    public $juser_fname, $juser_mname, $juser_lname, $juser_email, $juser_phone, $juser_affiliation, $juser_gender, $juser_salutation_id, $juser_country_id, $juser_degree, $juser_photo, $juser_interest, $juser_biography;

    public function mount()
    {
        $this->dispatch('contentChanged');
    }

    public function render()
    {
        $this->countries   = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();

        $this->record = auth()->user();
        $this->juser_salutation_id = $this->record->salutation_id;
        $this->juser_gender = $this->record->gender;
        $this->juser_fname  = $this->record->first_name;
        $this->juser_mname  = $this->record->middle_name;
        $this->juser_lname  = $this->record->last_name;
        $this->juser_email  = $this->record->email;
        $this->juser_phone  = $this->record->phone;
        $this->juser_affiliation  = $this->record->affiliation;
        $this->juser_country_id  = $this->record->country_id;
        $this->juser_degree   = $this->record->degree;
        $this->juser_interest = $this->record->interest;
        $this->juser_biography = $this->record->biography;

        return view('livewire.backend.profile');
    }

    public function rules()
    {
        return [
            'juser_fname' => 'required|string',
            'juser_mname' => 'nullable|string',
            'juser_lname' => 'required|string',
            'juser_gender' => 'required',
            'juser_phone'  => 'nullable|string',
        ];
    }

    public function updateUser()
    {
        $attributeNames = array(
            'juser_fname'  => 'First Name',
            'juser_mname'  => 'Middle Name',
            'juser_lname'  => 'Last Name',
            'juser_phone'  => 'Phone Number',
            'juser_gender' => 'Gender',
        );

        $this->validate($this->rules(), [], $attributeNames);

        $data = User::find(auth()->user()->id);
        
        $data->first_name    = $this->juser_fname;
        $data->middle_name   = $this->juser_mname;
        $data->last_name     = $this->juser_lname;
        $data->gender        = $this->juser_gender;
        $data->email         = $this->juser_email;
        $data->phone         = $this->juser_phone;
        $data->degree        = $this->juser_degree;
        $data->interests     = $this->juser_interest;
        $data->country_id    = $this->juser_country_id;
        $data->salutation_id = $this->juser_salutation_id;
        $data->affiliation   = $this->juser_affiliation;
        $data->biography     = $this->juser_biography;

        if($this->juser_photo){
            $file  = $this->juser_photo;
            $_name = $file->getClientOriginalName();
            $_type = $file->getClientOriginalExtension();
            $_file = str_replace(' ', '_', $_name);

            $file->storeAs('public/users/', $_file);

            $data->profile_photo_path = $_file;
        }

        $data->update();
        
        session()->flash('success', 'Your Profile Information is Successifully Updated');
    }
}
