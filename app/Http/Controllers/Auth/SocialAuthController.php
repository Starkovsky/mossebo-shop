<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use URL;
use Auth;
use Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialProvider;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
                return redirect()->to('login');
            }
        }
    }

    public function callback(Request $request, $provider = false)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        }
        catch (\InvalidArgumentException $e) {
            // TODO: Сохранить логи ошибок куда то
            if (app()->isLocal()) {
                return $e->getMessage();
            }
            else {
                return redirect()->route('login');
            }
        }
        catch (\Exception $e) {
            // TODO: Сохранить логи ошибок куда то
            if (app()->isLocal()) {
                return $e->getMessage();
            }
            else {
                return redirect()->route('login');
            }
        }

        $user = Auth::user();

        $socialProvider = SocialProvider::where('provider_user_id', $socialUser->getId())
            ->where('provider', $provider)
            ->first();

        if ($user) {
            if (! $socialProvider) {
                $user->socialProviders()->create([
                    'provider_user_id' => $socialUser->getId(),
                    'provider' => $provider
                ]);
            }

            return $this->redirectToReferer(siteUrl('cabinet'));
        }

        if ($socialProvider) {
            auth()->login($socialProvider->user);

            return $this->redirectToReferer();
        }

        $user = $socialUser->getRaw();

        $getUserData = function($label) use($user) {
            return isset($user[$label]) ? htmlspecialchars($user[$label]) : '';
        };

        return view('auth.register', [
            'socialUser' => $socialUser,
            'provider'   => $provider,
            'first_name' => $getUserData('first_name'),
            'last_name'  => $getUserData('last_name'),
            'email'      => $getUserData('email'),
            'phone'      => $getUserData('phone'),
        ]);
    }

    protected function redirectToReferer($default = '/')
    {
        $path = \Session::pull('login-referer');

        if (! $path) {
            $path = $default;
        }

        return redirect($path);
    }
}
