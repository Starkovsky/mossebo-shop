<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    //
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        // when facebook call us a with token
        try {
            $socialUserInfo = Socialite::driver($provider)->user();

            $user = User::firstOrCreate(['email' => $socialUserInfo->getEmail()]);

            $socialProfile = $user->socialProfile ?: new SocialLoginProfile;
            $providerField = "{$provider}_id";
            $socialProfile->{$providerField} = $socialUserInfo->getId();
            $user->socialProfile()->save($socialProfile);

            auth()->login($user);

        } catch (Exception $e) {
            throw new SocialAuthException("failed to authenticate with $provider");
        }
    }
}
