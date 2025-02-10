<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function home()
    {
        return view('backend.journals');
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
}
