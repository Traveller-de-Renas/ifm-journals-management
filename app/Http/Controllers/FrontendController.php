<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }

    public function viewall()
    {
        return view('frontend.journals');
    }

    public function journal_detail()
    {
        return view('frontend.journal_details');
    }

    public function journal_articles()
    {
        return view('frontend.articles');
    }

    public function journal_article()
    {
        return view('frontend.article_details');
    }

    public function callfor_paper()
    {
        return view('frontend.callfor_paper');
    }

    public function call_detail()
    {
        return view('frontend.call_detail');
    }

    public function article_download(Request $request)
    {
        $article = Article::where('uuid', $request->article)->first();
        $article->increment('downloads');

        return Storage::download('publications/'.$article->manuscript_file);
    }

    public function journal_editorial()
    {
        return view('frontend.editorial');
    }

    public function editorial_download(Request $request)
    {
        $issue = Issue::where('uuid', $request->issue)->first();
        $issue->increment('editorial_downloads');

        return Storage::download('editorial/'.$issue->editorial_file);
    }

    public function sliding_images()
    {
        return view('backend.sliding_images');
    }
}
