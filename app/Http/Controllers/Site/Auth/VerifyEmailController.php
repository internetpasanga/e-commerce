<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $user = User::where('email', $email)->first();

        if (! $user || ! $user->verifyEmailOtp($request->input('otp'))) {
            return back()->withErrors(['otp' => 'That code is invalid or has expired. Please try again or request a new one.']);
        }

        session()->forget('otp_email');

        return redirect()->route('login')->with('status', 'Your email has been verified. You can now log in.');
    }
}
