<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialProvider;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    /**
     * Редирект на социальную сеть за подтверждением
     * @param $provider
     * @return Response
     */
    public function redirect($provider = false)
    {
        try {
            return Socialite::driver($provider)->redirect();
        }
        catch (\Exception $e) {
            // TODO: Сохранить логи ошибок куда то
            if(app()->isLocal()) {
                return $e->getMessage();
            }
            else {
                return redirect()->route('login');
            }
        }
    }

    public function callback($provider = false)
    {
        try {

            $socialUser = Socialite::driver($provider)->stateless()->user();

        } catch (\InvalidArgumentException $e) {
            // TODO: Сохранить логи ошибок куда то
            if(app()->isLocal()) {
                return $e->getMessage();
            }
            else {
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            // TODO: Сохранить логи ошибок куда то
            if(app()->isLocal()) {
                return $e->getMessage();
            }
            else {
                return redirect()->route('login');
            }
        }

        $socialProvider = SocialProvider::where('provider_user_id', $socialUser->getId())->first();

        if ($socialProvider) {

            $user = $socialProvider->user;

            auth()->login($user);

            return redirect()->to('/');
        }
        else {
            return view('auth.register', [
                'socialUser' => $socialUser,
                'provider' => $provider,
            ]);
        }
    }
}
