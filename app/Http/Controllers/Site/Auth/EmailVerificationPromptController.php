<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(): View
    {
        return view('site.auth.verify-email');
    }
}
