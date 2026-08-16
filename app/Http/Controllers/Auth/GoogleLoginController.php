<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the admin to Google's OAuth consent screen.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after the admin authorizes access.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Google sign-in failed or was cancelled. Please try again.']);
        }

        $allowedEmail = config('admin.allowed_email');
        $googleEmail = $googleUser->getEmail();

        // Only the single, pre-configured admin email may log in.
        if (
            ! $allowedEmail
            || ! $googleEmail
            || ! hash_equals(strtolower($allowedEmail), strtolower($googleEmail))
        ) {
            return redirect()->route('login')
                ->withErrors(['google' => 'This Google account is not authorized to access the admin panel.']);
        }

        // Only verified Google accounts are trusted.
        if (method_exists($googleUser, 'user') && empty($googleUser->user['email_verified'] ?? true)) {
            return redirect()->route('login')
                ->withErrors(['google' => 'Your Google email must be verified to sign in.']);
        }

        $user = User::query()->firstOrNew(['email' => $googleEmail]);
        $user->name = $googleUser->getName() ?: 'Admin';
        $user->google_id = $googleUser->getId();

        if (! $user->exists) {
            // Local password auth is disabled for this account; the hash is
            // random and unusable since only Google login is accepted.
            $user->password = bcrypt(Str::random(40));
        }

        $user->save();

        Auth::login($user, remember: true);

        request()->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }
}
