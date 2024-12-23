<?php

namespace App\Livewire\Backend;

use App\Models\User;
use App\Models\Article;
use App\Models\Journal;
use Livewire\Component;
use App\Models\CallForPaper;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Dashboard extends Component
{
    public $users;
    public $journals;
    public $call_for_papers;
    
    public function render()
    {
        $this->users = User::count();
        $this->journals = Journal::count();
        $this->call_for_papers = CallForPaper::count();

        $columnChartModel = (new ColumnChartModel())
        ->setTitle('Articles Published Per Journal');

        $journals = Journal::with(['articles' => function ($query) {
            $query->whereHas('article_status', function ($qr) {
                $qr->where('code', '006');
            });
        }])->get();

        foreach ($journals as $key => $journal) {
            $columnChartModel->addColumn(strtoupper($journal->code), $journal->articles->count(), '#f6ad55');
        }



        $callPapersChart = (new ColumnChartModel())
        ->setTitle('Call For Papers Per Journal');

        $call_papers = Journal::all();

        foreach ($call_papers as $key => $jn) {
            $callPapersChart->addColumn(strtoupper($jn->code), $jn->call_for_papers->count(), '#159089');
        }


        
        return view('livewire.backend.dashboard', compact('columnChartModel', 'callPapersChart'));
    }
}
