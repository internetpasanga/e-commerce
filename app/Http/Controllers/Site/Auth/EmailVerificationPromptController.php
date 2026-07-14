<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        if (! session('otp_email')) {
            return redirect()->route('register');
        }

        return view('site.auth.verify-email', ['email' => session('otp_email')]);
    }
}
