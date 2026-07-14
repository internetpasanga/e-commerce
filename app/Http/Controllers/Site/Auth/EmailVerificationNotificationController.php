<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $email = $request->input('email') ?: session('otp_email');

        if ($email) {
            $user = User::where('email', $email)->first();

            if ($user && ! $user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }
        }

        return back()->with('status', 'If an account with that email exists and is unverified, a new verification code has been sent.');
    }
}
