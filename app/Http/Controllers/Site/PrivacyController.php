<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class PrivacyController extends Controller
{
    public function index(): View
    {
        $title = Setting::get('privacy_title') ?: 'Privacy Policy';
        $content = Setting::get('privacy_content') ?: '<p>Content for this page has not been added yet. Check back soon!</p>';

        return view('site.privacy', compact('title', 'content'));
    }
}
