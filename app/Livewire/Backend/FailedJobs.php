<?php

namespace App\Livewire\Backend;

use App\Models\FailedJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FailedJobs extends Component
{


    public $failedJobs;

    public function mount()
    {
        $this->loadFailedJobs();
    }

    public function loadFailedJobs()
    {
        $this->failedJobs = FailedJob::latest()->get();
    }

    public function retryJob($id)
    {
        $failed = DB::table('failed_jobs')->where('id', $id)->first();

        if (!$failed) {
            session()->flash('error', 'Failed job not found.');
            return;
        }

        $payload = json_decode($failed->payload, true);

        if (isset($payload['data']['command'])) {
            $job = unserialize($payload['data']['command']);
            dispatch($job); // Retry by re-dispatching
            DB::table('failed_jobs')->where('id', $id)->delete();
            session()->flash('message', 'Job re-dispatched manually.');
        } else {
            session()->flash('error', 'Unsupported job format.');
        }

        $this->loadFailedJobs();
    }

    public function forgetJob($id)
    {
        Artisan::call('queue:forget', ['id' => $id]);
        session()->flash('message', 'Job deleted successfully.');
        $this->loadFailedJobs();
    }

    public function render()
    {
        return view('livewire.backend.failed-jobs');
    }
}
