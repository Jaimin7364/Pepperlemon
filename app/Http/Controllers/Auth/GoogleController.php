<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(url('/auth/google/callback'))
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(url('/auth/google/callback'))
                ->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists but doesn't have a google_id, update it
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar
                    ]);
                }
                
                Auth::login($user);
                return redirect()->intended('/dashboard');
            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null // or bcrypt(Str::random(16)) if preferred, but nullable is better
                ]);

                Auth::login($newUser);
                return redirect()->intended('/dashboard');
            }
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong during Google Login. Please try again.');
        }
    }
}
