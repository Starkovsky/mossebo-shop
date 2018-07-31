<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\DefaultMessage;
use Settings;

class Checkout extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = new DefaultMessage();

        $products = [];

        foreach ($this->data['cart'] as $cartItem) {
            $productData = [
                'url'      => route('good', [
                    'id' => $cartItem['product']->id
                ]),
                'title'    => $cartItem['product']->currentI18n->title,
                'price'    => formatPrice($cartItem['finalPrice'], $this->data['currency_code']),
                'quantity' => $cartItem['quantity'],
                'total'    => formatPrice($cartItem['finalPrice'] * $cartItem['quantity'], $this->data['currency_code']),
            ];

            if ($cartItem['product']->image) {
                $imagePathes = json_decode($cartItem['product']->image->pathes);

                $productData['image'] = imagePath($imagePathes->thumb->srcset);
            }

            $products[] = $productData;
        }

        $checkoutData = [
            'total' => $this->data['finalAmount'],
            'products' => $products
        ];

        $message
            ->title(trans('shop.checkout.mail.title', [
                'orderId' => $this->data['id'],
                'site' => config('app.name'),
                'price' => str_replace(' ', '&nbsp;', $checkoutData['total'])
            ]))

            ->line(
                trans('shop.checkout.mail.info')
            )

            ->image('/assets/images/emails/checkout/', '/order-confirm.jpg', trans('shop.checkout.mail.confirm'))

            ->with([
                'title' => [
                    'title' => trans('shop.checkout.mail.products')
                ]
            ])

            ->with(['checkout' => $checkoutData])

            ->with([
                'data_table' => [
                    'title' => trans('shop.checkout.mail.personal'),
                    'data' => [
                        [
                            'label' => trans('shop.checkout.mail.form.name'),
                            'value' => $this->data['first_name']
                        ],
                        [
                            'label' => trans('shop.checkout.mail.form.surname'),
                            'value' => $this->data['last_name']
                        ],
                        [
                            'label' => trans('shop.checkout.mail.form.email'),
                            'value' => $this->data['email']
                        ],
                        [
                            'label' => trans('shop.checkout.mail.form.phone'),
                            'value' => $this->data['phone']
                        ],
                    ]
                ]
            ])

            ->separator()

            ->with([
                'data_table' => [
                    'title' => trans('shop.checkout.mail.address'),
                    'data' => [
                        [
                            'label' => trans('shop.checkout.mail.form.city'),
                            'value' => $this->data['city']
                        ],
                        [
                            'label' => trans('shop.checkout.mail.form.post_code'),
                            'value' => $this->data['post_code']
                        ],
                        [
                            'label' => trans('shop.checkout.mail.form.address'),
                            'value' => $this->data['address']
                        ],
                    ]
                ]
            ])

            ->separator()

            ->with([
                'title' => [
                    'title' => trans('shop.checkout.mail.pay_type')
                ]
            ])

            ->with(
                $this->data['pay_type']
            );

        if ($this->data['comment']) {
            $message
                ->separator()

                ->with([
                    'title' => [
                        'title' => trans('shop.checkout.mail.comment')
                    ]
                ])

                ->with([
                    'italic' => [
                        'text' => $this->data['comment']
                    ]
                ]);
        }

        $message
            ->footer(trans('shop.checkout.mail.footer', [
                'orderId' => $this->data['id'],
                'email'   => Settings::get('notify-help-email'),
                'phone'   => str_replace(' ', '&nbsp;', Settings::get('notify-help-phone'))
            ]));

        $this
            ->subject(trans('shop.checkout.success'))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('vendor.notifications.email')
            ->with($message->toArray());
    }
}