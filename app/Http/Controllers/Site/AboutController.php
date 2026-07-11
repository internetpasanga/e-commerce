<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $title = Setting::get('about_us_title') ?: 'About Us';
        $content = Setting::get('about_us_content') ?: '<p>Content for this page has not been added yet. Check back soon!</p>';

        return view('site.about', compact('title', 'content'));
    }
}
