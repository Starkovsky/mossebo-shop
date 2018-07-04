<?php

namespace App\Notifications\Auth;

use Lang;
use Auth;
use Settings;
use App\Notifications\Base\BaseNotification;

class Registration extends BaseNotification
{
    public function toMail($notifiable)
    {
        return $this->newMailMessage()
            ->subject(trans('mail.registration.subject', ['site' => config('app.name')]))
            ->title(trans('mail.registration.title', ['site' => config('app.name')]))
            ->line(trans('mail.registration.hello', ['name' => Auth::user()->getFullName()]))
            ->line(trans('mail.registration.line-1', ['site' => config('app.name')]))
            ->line(trans('mail.registration.line-2'))
            ->image('assets/images/emails/auth', 'registration.jpg', trans('mail.registration.alt'))
            ->action(trans('mail.registration.button'), siteUrl('catalog'))
            ->footer(trans('mail.registration.footer', [
                'email' => Settings::get('notify-help-email'),
                'phone' => Settings::get('notify-help-phone')
            ]));
    }
}
