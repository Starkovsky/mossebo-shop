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
            ->to($notifiable->email, $notifiable->getFullName())
            ->title(trans('mail.registration.title', ['site' => config('app.name')]))
            ->line(trans('mail.registration.hello', ['name' => $notifiable->getFullName()]))
            ->line(trans('mail.registration.line-1', ['site' => config('app.name')]))
            ->line(trans('mail.registration.line-2'))
            ->image('assets/images/emails/auth', 'registration.jpg', trans('mail.registration.alt'))
            ->action(trans('mail.registration.button'), siteUrl('catalog'))
            ->footer($this->mailFooterText('mail.registration.footer'));
    }
}
