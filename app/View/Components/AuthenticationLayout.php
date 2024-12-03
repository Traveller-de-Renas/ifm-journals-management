<?php

namespace App\View\Components;

use App\Models\SocialMedia;
use Illuminate\View\Component;

class AuthenticationLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render()
    {
        $social_media = SocialMedia::orderBy('id', 'desc')->get();
        $quick_links  = collect();
        return view('layouts.authentication', compact('social_media', 'quick_links'));
    }
}
