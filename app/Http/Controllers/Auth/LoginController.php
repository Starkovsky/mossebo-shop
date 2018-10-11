<?php

namespace App\Http\Controllers\Auth;

use URL;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        \Session::put('login-referer', URL::previous());

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $referer = \Session::pull('login-referer');

        if ($referer) {
            return redirect($referer);
        }
    }

    protected function loggedOut()
    {
        if ($referer = $this->getReferer()) {
            $url = $referer;
        }
        else {
            $url = '/';
        }

        return redirect()->intended($url);
    }

    protected function getReferer()
    {
        $referer = URL::previous();

        if ($referer) {
            $route = app('router')->getRoutes()->match(
                app('request')->create($referer)
            );

            if ($route) {
                return $referer;
            }
        }

        return false;
    }

    protected function sendLoginResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'redirect' => $this->getReferer()
            ]);
        }
        else {
            return parent::sendLoginResponse($request);
        }
    }
}
