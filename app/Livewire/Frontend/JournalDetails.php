<?php

namespace App\Livewire\Frontend;

use App\Models\User;
use App\Models\Country;
use App\Models\Journal;
use Livewire\Component;
use App\Models\Salutation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JournalDetails extends Component
{
    public $record;
    public $seditor;
    public $editor_search;
    public $editor_names;
    public $editor_detail = '';

    public $signupModal  = false;
    public $countries    = [];
    public $salutations  = [];
    public $create_juser = false;
    public $juser_fname, $juser_mname, $juser_lname, $juser_email, $juser_phone, $juser_affiliation, $juser_gender, $juser_salutation_id, $juser_country_id;

    public $tab    = 'overview';
    public $subtab = 'all_issues';

    public function mount(Request $request){

        if(!Str::isUuid($request->journal)){
            abort(404);
        }
        
        $this->record = Journal::where('uuid', $request->journal)->first();
        if(empty($this->record)){
            abort(404);
        }

        $this->countries   = Country::all()->pluck('name', 'id')->toArray();
        $this->salutations = Salutation::all()->pluck('title', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.frontend.journal-details');
    }

    public function searchEditor($string)
    {
        if($string != ''){
            $this->editor_search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
            $this->editor_names = User::when($this->editor_search, function($query){
                return $query->where(function($query){
                    $query->where('first_name', 'ilike', '%'.$this->editor_search.'%')->orWhere('middle_name', 'ilike', '%'.$this->editor_search.'%')->orWhere('last_name', 'ilike', '%'.$this->editor_search.'%');
                });
            })->orderBy('first_name', 'ASC')->get();
        }
    }

    public function assignEditor(User $editor)
    {
        $this->seditor = '';
        $editor->journals()->sync([$this->record->id => ['role' => 'editor']]);
    }

    public function removeEditor(User $editor)
    {
        $editor->journals()->detach($this->record->id);
    }

    public function editorDetails($key)
    {
        if ($key == $this->editor_detail) {
            $this->editor_detail = '';
        }else{
            $this->editor_detail = $key;
        }
    }

    public function createJuser()
    {
        $this->create_juser = true;
    }

    public function storeJuser()
    {
        $this->validate([
            'juser_fname'       => 'required',
            'juser_mname'       => 'nullable',
            'juser_lname'       => 'required',
            'juser_email'       => 'nullable|email|unique:users,email',
            'juser_phone'       => 'nullable|numeric',
            'juser_affiliation' => 'nullable'
        ]);

        $juser = User::create([
            'first_name'   => $this->juser_fname,
            'middle_name'  => $this->juser_mname,
            'last_name'    => $this->juser_lname,
            'gender'       => $this->juser_gender,
            'email'        => $this->juser_email,
            'phone'        => $this->juser_phone,
            'affiliation'  => $this->juser_affiliation,
            'country_id'   => $this->juser_country_id,
            'password'     => Hash::make('admin@ifm123EMS'),
        ]);

        $this->reset(['juser_fname', 'juser_mname', 'juser_lname', 'juser_email', 'juser_phone', 'juser_affiliation']);

        $this->assignEditor($juser);

        $this->create_juser = false;
    }

    public function signup()
    {
        $this->signupModal = true;
    }

    public function confirmSignUp()
    {
        Auth::user()->journals()->sync([$this->record->id => ['role' => 'author']]);
        $this->signupModal = false;
        
        session()->flash('success', 'You are successfully registered as an author on this journal');
    }

    public function changeTab($tab)
    {
        $this->tab = $tab;
    }

    public function changeSubTab($subtab)
    {
        $this->subtab = $subtab;
    }
}
