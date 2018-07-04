<?php

namespace App\Support\Traits\Models;

use App\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use App\Notifications\Auth\Registration as RegistrationNotification;

trait AuthNotifications
{
    public function sendRegistrationNotification()
    {
        $this->notify(new RegistrationNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
