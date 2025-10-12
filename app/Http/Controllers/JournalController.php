<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function home()
    {
        return view('backend.journals');
    }

    public function dashboard()
    {
        return view('backend.dashboard');
    }

    public function index()
    {
        return view('backend.journals');
    }

    public function create()
    {
        return view('backend.create_journal');
    }

    public function subjects()
    {
        return view('backend.subjects');
    }

    public function categories()
    {
        return view('backend.categories');
    }

    public function review_messages()
    {
        return view('backend.review_messages');
    }

    public function review_sections()
    {
        return view('backend.review_sections');
    }

    public function file_categories()
    {
        return view('backend.file_categories');
    }

    public function submission_confirmations()
    {
        return view('backend.submission_confirmations');
    }

    public function detail()
    {
        return view('backend.detail');
    }

    public function submission()
    {
        return view('backend.submission');
    }

    public function submission_manually()
    {
        return view('backend.submission_manually');
    }

    public function articles()
    {
        return view('backend.articles');
    }

    public function team()
    {
        return view('backend.journal_team');
    }

    public function reviewers()
    {
        return view('backend.journal_reviewers');
    }


    public function users()
    {
        return view('backend.journal_users');
    }

    public function article()
    {
        return view('backend.article');
    }

    public function article_evaluation()
    {
        return view('backend.article_evaluation');
    }

    public function publication()
    {
        return view('backend.publication_process');
    }

    public function call_for_papers()
    {
        return view('backend.call_for_papers');
    }

    public function peer_review_process()
    {
        return view('frontend.peer_review_process');
    }

    public function exit_journal()
    {
        if(session()->has('journal')){
            session()->forget('journal');

            return redirect(route('journals.dashboard'));
        }
    }

    public function editor_checklist()
    {
        return view('backend.editor_checklist');
    }


    public function editor_guide()
    {
        return view('backend.editor_guide');
    }

    public function editor_guideline()
    {
        $path = storage_path('app/public/journals/'.request()->document);
        return response()->file($path);
    }




    public function author_guideline()
    {
        $path = storage_path('app/public/journals/'.request()->document);
        return response()->file($path);
    } 

}
