<?php

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function (){
    $articles = Article::where('deadline', '<', Carbon::now())->get();

    foreach($articles as $article){

        $mail_logs = $article->mail_logs()->where('article_status_id', $article->article_status_id)->orderBy('created_at', 'DESC')->first();

        if($mail_logs){
            logger('Log Ipo tunacheck imara ya mwisho ilikuwa siku ngapi zilizopita kama ni siku tatu tunatuma kama hazijapita hatutumi');

        }else{
            logger('Log Haipo tunatengeneza log mpya kwa status hiyo');

        }

        
    }
    
})->everyMinute();