<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\View\View;

class TermsController extends Controller
{
    public function index(): View
    {
        $title = Setting::get('terms_title') ?: 'Terms of Service';
        $content = Setting::get('terms_content') ?: '<p>Content for this page has not been added yet. Check back soon!</p>';

        return view('site.terms', compact('title', 'content'));
    }
}
