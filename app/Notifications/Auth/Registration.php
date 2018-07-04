<?php

namespace App\Notifications\Auth;

use Lang;
use Auth;
use App\Notifications\Base\BaseNotification;

class Registration extends BaseNotification
{
    public function toMail($notifiable)
    {
        // todo: вынести email и номер телефона куда-то
        return $this->newMailMessage()
            ->title(trans('mail.registration.title', ['site' => config('app.name')]))
            ->line(Lang::get('mail.registration.hello', ['name' => Auth::user()->getFullName()]))
            ->line(Lang::get('mail.registration.line-1', ['site' => config('app.name')]))
            ->line(Lang::get('mail.registration.line-2'))
            ->image('assets/images/emails/auth', 'registration.jpg', Lang::get('mail.registration.alt'))
            ->action(Lang::get('mail.registration.button'), siteUrl('catalog'))
            ->footer(Lang::get('mail.registration.footer', ['email' => 'help@mossebo.market', 'phone' => '8 (800) 707-83-47']));
    }
}
