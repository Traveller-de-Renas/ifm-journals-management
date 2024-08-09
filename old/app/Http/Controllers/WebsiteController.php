<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function sliding_images()
    {
        return view('backend.sliding_images');
    }

    public function contacts()
    {
        return view('backend.contacts');
    }

    public function social_medias()
    {
        return view('backend.social_medias');
    }
}
