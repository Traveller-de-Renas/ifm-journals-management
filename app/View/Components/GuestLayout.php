<?php

namespace App\View\Components;

use Illuminate\View\View;
use App\Models\SocialMedia;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $social_media = SocialMedia::orderBy('id', 'desc')->get();
        $quick_links  = collect();
        return view('layouts.guest', compact('social_media', 'quick_links'));
    }
}
