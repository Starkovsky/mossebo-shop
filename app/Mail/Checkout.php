<?php

namespace App\Mail;

use Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\DefaultMessage;
use MosseboShopCore\Contracts\Shop\Order\Order;
use Shop;

class Checkout extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    protected function getProducts()
    {
        $products = [];
        $currentLanguage = Shop::getCurrentLanguage();

        foreach ($this->order->getCart()->getProducts() as $cartProduct) {
            $productData = [
                'url'      => route('good', [
                    'id' => $cartProduct->getProductId()
                ]),

                'title'    => $cartProduct->getTitle($currentLanguage->code),

                'quantity' => $cartProduct->getQuantity(),

                'price'    => $cartProduct->getFinalPrice()->getFormatted(),

                'total'    => $cartProduct->getTotalFinalPrice()->getFormatted(),
            ];

            $image = $cartProduct->getImage();

            if ($image) {
                $productData['image'] = imagePath($image['thumb']['srcset']);
            }

            $products[] = $productData;
        }

        return $products;
    }

    protected function getPersonDataTable()
    {
        $customer = $this->order->getCustomer();

        return [
            'title' => trans('shop.checkout.mail.personal'),
            'data' => [
                [
                    'label' => trans('shop.checkout.mail.form.name'),
                    'value' => $customer->getAttribute('first_name')
                ],
                [
                    'label' => trans('shop.checkout.mail.form.surname'),
                    'value' => $customer->getAttribute('last_name')
                ],
                [
                    'label' => trans('shop.checkout.mail.form.email'),
                    'value' => $customer->getAttribute('email')
                ],
                [
                    'label' => trans('shop.checkout.mail.form.phone'),
                    'value' => $customer->getAttribute('phone')
                ],
            ]
        ];
    }

    protected function getAddressDataTable()
    {
        $shipping = $this->order->getShipping();

        foreach (['city', 'post_code', 'street', 'house_number', 'apartment', 'floor', 'entrance', 'intercom'] as $key) {
            if ($value = $shipping->getAttribute($key)) {
                $data[] = [
                    'label' => trans('shop.checkout.mail.form.' . $key),
                    'value' => $shipping->getAttribute($key)
                ];
            }
        }

        return [
            'title' => trans('shop.checkout.mail.address'),
            'data' => $data
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = new DefaultMessage();

        $cart = $this->order->getCart();

        $checkoutData = [
            'total' => $cart->getTotal()->getFormatted(),
            'products' => $this->getProducts()
        ];

        if ($promoPrice = $cart->getPromoDiscountPrice()) {
            $checkoutData['promo'] = $promoPrice->getFormatted();
        }

        $message
            ->title(trans('shop.checkout.mail.title', [
                'orderId' => $this->order->getId(),
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
                'data_table' => $this->getPersonDataTable()
            ])

            ->separator()

            ->with([
                'data_table' => $this->getAddressDataTable()
            ]);

//            ->separator()
//
//            ->with([
//                'title' => [
//                    'title' => trans('shop.checkout.mail.pay_type')
//                ]
//            ])
//
//            ->with(
//                $this->data['pay_type']
//            );

        if ($comment = $this->order->getComment()) {
            $message
                ->separator()

                ->with([
                    'title' => [
                        'title' => trans('shop.checkout.mail.comment')
                    ]
                ])

                ->with([
                    'italic' => [
                        'text' => $comment
                    ]
                ]);
        }

        $message
            ->footer(trans('shop.checkout.mail.footer', [
                'orderId' => $this->order->getId(),
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
