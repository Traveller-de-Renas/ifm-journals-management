<?php

namespace App\Livewire\Backend;

use Livewire\Component;

class UsageManual extends Component
{
    public function render()
    {
        return view('livewire.backend.usage-manual');
    }

    public $userManual = false;
    public function openManual()
    {
        $this->userManual = true;
    }

    public function closeManual()
    {
        $this->userManual = false;
    }
}
