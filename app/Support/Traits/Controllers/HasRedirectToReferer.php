<?php

namespace App\Support\Traits\Controllers;

use URL;
use Session;

trait HasRedirectToReferer
{
    protected function storeReferer()
    {
        if ($referer = $this->getReferer()) {
            Session::put('auth-referer', $referer);
        }
    }

    protected function pullReferer()
    {
        return Session::pull('auth-referer');
    }

    protected function getRedirectUrl()
    {
        return $this->pullReferer() ?: route('home');
    }

    protected function getReferer()
    {
        $referer = URL::previous();

        if ($referer && !$this->refererDisabled($referer)) {
            return $referer;
        }

        return false;
    }

    protected function refererDisabled($referer)
    {
        $route = app('router')->getRoutes()->match(
            app('request')->create($referer)
        );

        return !$route || in_array($route->getName(), [
            'login',
            'logout',
            'login-social',
            'login-social.callback',
            'register',
            'password.request',
            'password.email',
            'password.reset'
        ]);
    }
}
