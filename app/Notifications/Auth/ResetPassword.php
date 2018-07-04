<?php

namespace App\Notifications\Auth;

use Lang;
use Auth;
use Settings;
use App\Notifications\Base\BaseNotification;

class ResetPassword extends BaseNotification
{
    public $token;

    public static $toMailCallback;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $resetLink = url(config('app.url') . route('password.reset', $this->token, false));

        return $this->newMailMessage()
            ->subject(trans('mail.reset-password.subject', ['site' => config('app.name')]))
            ->title(trans('mail.reset-password.title', ['site' => config('app.name')]))
            ->line(trans('mail.reset-password.line-1'))
            ->line("<a href=\"{$resetLink}\" target=\"_blank\">{$resetLink}</a>")
            ->line(trans('mail.reset-password.line-3'))
            ->line(trans('mail.reset-password.line-4', ['home' => url('/')]))
            ->image('assets/images/emails/auth', 'reset.jpg', trans('mail.reset-password.alt'))
            ->action(trans('mail.reset-password.button'), $resetLink)
            ->footer($this->mailFooterText('mail.reset-password.footer'));
    }
}
