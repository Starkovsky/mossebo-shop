<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Shop\Product;

class OneClick extends Mailable
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
        $product = Product::with([
            'currentPrice',
            'currentI18n',
            'image',
        ])->where('id', $this->userData['id'])->firstOrFail();

        $productData = [
            'title' => $product->currentI18n->title,
            'url'   => siteUrl($product->url()),
            'price' => $product->currentPrice->getFormatted()
        ];

        if ($product->image) {
            $imagePathes = json_decode($product->image->pathes);

            $productData['image'] = 'https://admin.mossebo.market' . $imagePathes->thumb->srcset;
        }

        $this
            ->subject(trans('form.one-click.subject', ['product' => $productData['title']]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('vendor.notifications.email')->with([
                'locale'  => app()->getLocale(),
                'title'   => trans('form.one-click.title'),

                'content' => [
                    trans('form.phone', ['phone' => $this->userData['phone']]),
                    trans('form.product'),

                    [
                        'product' => $productData
                    ]
                ],
            ]);
    }
}
