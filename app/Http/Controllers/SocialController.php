<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class SocialController extends Controller
{

    public function __construct(){
        $this->middleware(['customer']);
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->email)->first();
        if(!$user)
        {
            $user = User::create([
                'user_name' => $googleUser->user_name, 
                'email' => $googleUser->email,
                'password' =>Hash::make(rand(100000,999999))]);
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    /**
     * @return RedirectResponse
     */
    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * @return RedirectResponse
     */
    public function handleFacebookCallback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->user();

        $existingUser = User::where('facebook_id', $user->id)->first();

        if ($existingUser) {
            // Log in the existing user.
            auth()->login($existingUser, true);
        } else {
            // Create a new user.
            $newUser = new User();
            $newUser->user_name = $user->user_name;
            $newUser->email = $user->email;
            $newUser->facebook_id = $user->id;
            $newUser->password=Hash::make(rand(100000,999999));// Set some random password
            $newUser->save();

            // Log in the new user.
            auth()->login($newUser, true);
        }

        // Redirect to url as requested by user, if empty use /dashboard page as generated by Jetstream
        return redirect();
    }
}

