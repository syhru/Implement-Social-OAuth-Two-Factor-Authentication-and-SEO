<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $socialAccount = SocialAccount::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($socialAccount) {
                // Account exists, login user
                $user = $socialAccount->user;
            } else {
                // Check if user with same email exists
                $user = User::where('email', $socialUser->getEmail())->first();

                if (!$user) {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                        'email' => $socialUser->getEmail(),
                        'password' => null, // Password can be null for social logins
                        'two_factor_enabled' => false,
                    ]);
                }

                // Create social account
                $user->socialAccounts()->create([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'token' => $socialUser->token,
                ]);
            }

            Auth::login($user);

            if ($user->two_factor_enabled) {
                return redirect()->route('otp.verify.form');
            }

            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Failed to authenticate using ' . ucfirst($provider)]);
        }
    }
}
