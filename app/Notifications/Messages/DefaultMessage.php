<?php

namespace App\Notifications\Messages;

use Settings;
use Illuminate\Notifications\Action;
use Illuminate\Notifications\Messages\MailMessage;


class DefaultMessage extends MailMessage
{
    public $locale;
    public $actionImage;
    public $actionButton;
    public $title;
    public $socials;
    public $footerText;

    public function __construct($locale = null)
    {
        $this->locale = $locale ?: \App::getLocale();

        $this->socials = Settings::notifySocials()->reduce(function ($carry, $item) {
            $carry[] = [
                'title' => ucfirst($item->key),
                'url' => $item->value,
                'image' => asset('assets/images/emails/socials/' . strtolower($item->key) . '.png'),
            ];

            return $carry;
        }, []);
    }

    public function image($imageFolder, $imageName, $alt = null)
    {
        $imagePath = '/' . join('/', [
            trim($imageFolder, '/'),
            $this->locale,
            $imageName
        ]);

        $this->actionImage = [
            'alt' => $alt,
            'path' => url($imagePath)
        ];

        return $this;
    }

    public function action($text, $url)
    {
        $this->actionButton = [
            'text' => $text,
            'url' => $url
        ];

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function footer($footer)
    {
        $this->footerText = $footer;

        return $this;
    }

    public function with($line)
    {
        if ($line instanceof Action) {
            $this->action($line->text, $line->url);
        }
        elseif (! $this->actionText) {
            $this->introLines[] = $this->formatLine($line);
        }

        return $this;
    }

    public function separator()
    {
        $this->introLines[] = [
            'separator' => []
        ];

        return $this;
    }

    protected function formatLine($line)
    {
        if ($line instanceof Htmlable) {
            return $line;
        }

        if (is_array($line)) {
            return $line;
        }

        return trim(implode(' ', array_map('trim', preg_split('/\\r\\n|\\r|\\n/', $line))));
    }

    public function toArray()
    {
        return [
            'subject'      => $this->subject,
            'locale'       => $this->locale,
            'actionImage'  => $this->actionImage,
            'actionButton' => $this->actionButton,
            'title'        => $this->title,
            'socials'      => $this->socials,
            'content'      => $this->introLines,
            'footerText'   => $this->footerText
        ];
    }
}
