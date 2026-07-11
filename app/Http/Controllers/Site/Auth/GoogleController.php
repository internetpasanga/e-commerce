<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Cart;
use App\Support\GoogleAuth;
use App\Support\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        abort_if(! GoogleAuth::isConfigured(), 404);

        Config::set('services.google.redirect', route('auth.google.callback'));

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        abort_if(! GoogleAuth::isConfigured(), 404);

        Config::set('services.google.redirect', route('auth.google.callback'));

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Google User',
                'email' => $googleUser->getEmail(),
                'password' => Str::random(40),
                'is_admin' => false,
            ]);
        }

        if (! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, true);

        $request->session()->regenerate();

        Cart::mergeSessionIntoDatabase(Auth::id());
        Wishlist::mergeSessionIntoDatabase(Auth::id());

        return redirect()->intended(route('home'));
    }
}
