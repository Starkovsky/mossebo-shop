<?php

namespace App\Http\Controllers\Auth;

use App\Support\Traits\Controllers\HasRedirectToReferer;
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

    use AuthenticatesUsers, HasRedirectToReferer;

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
        $this->storeReferer();

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect($this->getRedirectUrl());
    }

    protected function loggedOut()
    {
        return redirect()->intended(
            $this->getRedirectUrl()
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'redirect' => $this->getRedirectUrl()
            ]);
        }
        else {
            return parent::sendLoginResponse($request);
        }
    }
}
