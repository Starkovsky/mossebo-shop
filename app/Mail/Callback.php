<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Callback extends Mailable
{
    use Queueable, SerializesModels;

    protected $userData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject(trans('form.callback.subject', ['site' => config('app.name')]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('vendor.notifications.email')->with([
                'locale'  => app()->getLocale(),
                'title'   => trans('form.callback.title', ['site' => config('app.name')]),
                'content' => [
                    trans('form.name', ['name' => $this->userData['name']]),
                    trans('form.phone', ['phone' => $this->userData['phone']])
                ]
            ]);
    }
}
