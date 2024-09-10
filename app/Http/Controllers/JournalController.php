<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        return view('backend.journals');
    }

    public function form()
    {
        return view('backend.journals_form');
    }

    public function subjects()
    {
        return view('backend.subjects');
    }

    public function categories()
    {
        return view('backend.categories');
    }

    public function details()
    {
        return view('backend.journal_details');
    }

    public function submission()
    {
        return view('backend.paper_submission');
    }

    public function articles()
    {
        return view('backend.articles');
    }

    public function article()
    {
        return view('backend.article_details');
    }

    public function article_evaluation()
    {
        return view('backend.article_evaluation');
    }
    
    public function journal_detail()
    {
        return view('frontend.journal_details');
    }

    public function viewall()
    {
        return view('frontend.journals');
    }

    public function journal_articles()
    {
        return view('frontend.articles');
    }

    public function journal_article()
    {
        return view('frontend.article_details');
    }

    public function archive()
    {
        return view('backend.volumes');
    }

    public function journal_archive()
    {
        return view('frontend.volumes');
    }
}
