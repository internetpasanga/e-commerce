<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Support\Cart;
use App\Support\GoogleAuth;
use App\Support\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('site.auth.login', ['googleEnabled' => GoogleAuth::isConfigured()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
        }

        if (! Auth::user()->hasVerifiedEmail()) {
            Auth::logout();

            return back()->withErrors(['email' => 'Please verify your email address before logging in. Check your inbox for the verification link.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        Cart::mergeSessionIntoDatabase(Auth::id());
        Wishlist::mergeSessionIntoDatabase(Auth::id());

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
