<?php

namespace App\Livewire\Backend;

use App\Models\Campus;
use App\Models\Faculty;
use Livewire\Component;
use App\Models\StaffList;
use App\Models\Department;
use App\Models\Salutation;
use App\Models\Designation;
use App\Models\Publication;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\PublicationType;
use App\Models\PublicationCategory;
use Illuminate\Support\Facades\Http;

class StaffLists extends Component
{
    use WithPagination;

    public $query;
    public $sortBy  = 'id';
    public $sortAsc = false; 

    public $Add;
    public $Edit;
    public $Delete;

    public $record;
    public $first_name;
    public $status;
    public $middle_name;
    public $last_name;
    public $gender;
    public $nationality;
    public $email;
    public $phone;
    public $box;
    public $bio;
    public $faculty;
    public $campus;
    public $picture;
    public $salutation;

    public $substantive_post;
    public $acting_duty_post;
    public $duty_post;

    public $campuses;
    public $faculties;
    public $salutations;
    public $designations;

    public $form = false;

    public function mount()
    {
        $this->campuses    = Campus::all()->pluck('name', 'id')->toArray();
        $this->faculties   = Faculty::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();
    }

    public function render()
    {
        $staff_list = StaffList::when($this->query, function($query){
            return $query->where(function($query){
                $query->where('first_name', 'ilike', '%'.$this->query.'%')->orWhere('middle_name', 'ilike', '%'.$this->query.'%')->orWhere('last_name', 'ilike', '%'.$this->query.'%')->orWhere('full_name', 'ilike', '%'.$this->query.'%');
            });
        })->orderBy( 'id',  'DESC');
        
        $staff_list = $staff_list->paginate(20);

        return view('livewire.backend.staff-lists', compact('staff_list'));
    }

    public function sort($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function add()
    {
        $this->dispatch('editor');
        $this->form = true;
    }

    public function edit(StaffList $data)
    {
        $this->dispatch('editor');

        $this->record       = $data;
        $this->first_name   = $data->first_name;
        $this->middle_name  = $data->middle_name;
        $this->last_name    = $data->last_name;
        $this->bio          = $data->bio;
        $this->box          = $data->box;
        $this->email        = $data->email;
        $this->campus       = $data->campus_id;
        $this->faculty      = $data->faculty_id;
        $this->gender       = $data->gender;
        $this->nationality  = $data->nationality;
        $this->status       = $data->status;
        $this->salutation   = $data->salutation_id;

        $this->form = true;
    }

    public function confirmDelete(StaffList $data)
    {
        $this->record = $data;
        $this->Delete = true;
    }

    public function rules()
    {
        return [
            'salutation'  => 'required|integer',
            'first_name'  => 'required|string',
            'middle_name' => 'required|string',
            'last_name'   => 'required|string',
            'gender'      => 'required',
            'email'       => 'required|email',
            'faculty'     => 'required|integer',
            'campus'      => 'required|integer',
        ];
    }

    public function store()
    {
        $this->validate();
        $data = new StaffList;
        $data->create([
            'salutation_id' => $this->salutation,
            'first_name'    => $this->first_name,
            'middle_name'   => $this->middle_name,
            'last_name'     => $this->last_name,
            'full_name'     => $this->first_name.' '.$this->middle_name.' '.$this->last_name,
            'gender'        => $this->gender,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'box'           => $this->box,
            'bio'           => $this->bio,
            'faculty_id'    => $this->faculty,
            'campus_id'     => $this->campus,
            'nationality'   => $this->nationality,
            'status'        => $this->status,
        ]);
        
        session()->flash('success', 'Saved Successifully');
        $this->form = false;
    }

    public function update(StaffList $data)
    {
        $this->validate();
        $data->update([
            'salutation_id' => $this->salutation,
            'first_name'    => $this->first_name,
            'middle_name'   => $this->middle_name,
            'last_name'     => $this->last_name,
            'full_name'     => $this->first_name.' '.$this->middle_name.' '.$this->last_name,
            'gender'        => $this->gender,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'box'           => $this->box,
            'bio'           => $this->bio,
            'faculty_id'    => $this->faculty,
            'campus_id'     => $this->campus,
            'nationality'   => $this->nationality,
            'status'        => $this->status,
        ]);
        
        session()->flash('success', 'Updated Successifully');
        $this->form = false;
    }

    public function delete(StaffList $data)
    {
        if($data->delete()){
            session()->flash('success', 'Deleted Successifully');
            $this->Delete = false;
        }
    }


    public function from_ems()
    {
        $client_id     = '5seKXSC1HgjY16Na13ueon6JzyFWAb8bkDP0LSYrVuCfpr19kJG2Nsch2nr5ps7i';
        $client_secret = 'Vyca3tYriG2o3K5wrSPTJZTbu17Crck9ENcNsv7xlEdH0MQunYZhN0XFAlNigsTH';

        $staff_l = Http::withoutVerifying()->withOptions(["verify"=>false])->acceptJson()->withHeaders([
            'clientId' => $client_id,
            'clientSecret' => $client_secret
        ])->post('https://ems.ifm.ac.tz/staff/api/get-profiles')->body();


        $staff_lst = json_decode($staff_l);
        $status    = $staff_lst->status->code;

        if($status == '200'){
            $data = $staff_lst->body;

           // dd($data);

            foreach($data as $staff){
                if($staff->facultyCode != ""){
                    $faculty = Faculty::updateOrCreate(
                        [ 'code' => $staff->facultyCode ],
                        [ 'name' => $staff->faculty, 'code' => $staff->facultyCode]
                    );
                }else{
                    $faculty = null;
                }

                if($staff->campus != ""){
                    $campus = Campus::firstOrCreate(
                        [ 'name' => $staff->campus ],
                        [ 'name' => $staff->campus ]
                    );
                }else{
                    $campus = null;
                }

                if($staff->title != ""){
                    $salutation = Salutation::firstOrCreate(
                        [ 'title' => $staff->title ],
                        [ 'title' => $staff->title ]
                    );
                }else{
                    $salutation = null;
                }
                
                $facultyid      = (!is_null($faculty))? $faculty->id : null ;
                $campusid       = (!is_null($campus))? $campus->id : null ;
                $salutationid   = (!is_null($salutation))? $salutation->id : null ;

                $_staff    = StaffList::updateOrCreate(
                    [
                        'ems_id'=> $staff->uniqueIdentifier
                    ],
                    [
                        'salutation_id'     => $salutationid,
                        'first_name'        => $staff->firstName,
                        'middle_name'       => $staff->middleName,
                        'last_name'         => $staff->lastName,
                        'full_name'         => $staff->firstName.' '.$staff->middleName.' '.$staff->lastName,
                        'pf_number'         => $staff->pfNumber,
                        'password'          => $staff->secretKey,
                        'picture'           => $staff->picture_url,
                        'gender'            => $staff->gender,
                        'nationality'       => $staff->nationality,
                        'email'             => $staff->email,
                        'phone'             => json_encode($staff->personalContacts),
                        'bio'               => $staff->bio,
                        'ems_id'            => $staff->uniqueIdentifier,
                        'status'            => $staff->status,
                        'faculty_id'        => $facultyid,
                        'campus_id'         => $campusid,
                        'designations'      => json_encode($staff->designations),
                        'office'            => $staff->office,
                        'social_media'      => json_encode($staff->socialMedia),
                        'academics'         => json_encode($staff->academicQualifications),
                    ]
                );
            }

            session()->flash('success', 'Saved Successifully');
        }else{
            session()->flash('danger', 'Failed');
        }
    }

    public function updateUuid()
    {
        $staff_list = StaffList::all();
        foreach($staff_list as $staff){
            $staff->update([
                'uuid' => Str::uuid()
            ]);
        }
    }
}
