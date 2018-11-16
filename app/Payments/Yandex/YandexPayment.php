<?php

namespace App\Payments\Yandex;

use Illuminate\Http\Request;
use YandexCheckout\Client;
use Exception;
use Currencies;
use MosseboShopCore\Contracts\Shop\Order\Order;

class YandexPayment
{
    protected $shopId = null;
    protected $secretKey = null;
    protected $order = null;

    public function __construct(Order $order = null)
    {
        $this->shopId       = env('YANDEX_PAYMENT_SHOP_ID');
        $this->secretKey    = env('YANDEX_PAYMENT_SECRET_KEY');

        $this->setOrder($order);
    }

    public function setOrder(Order $order = null)
    {
        $this->order = $order;
    }

    public function getPayment($paymentId)
    {
        return $this->getClient()->getPaymentInfo($paymentId);
    }

    public function getPaymentStatus($paymentId)
    {
        return $this->getPayment($paymentId)->getStatus();
    }

    protected function getClient()
    {
        $client = new Client();

        $client->setAuth(
            $this->shopId,
            $this->secretKey
        );

        return $client;
    }

    public function sendRequest()
    {
        $client = $this->getClient();

        return $client->createPayment(
            [
                'amount'       => $this->getAmount(),
                'confirmation' => $this->getConfirmation(),
                'description'  => $this->getDescription(),
            ],
            $this->getIdempotencyKey()
        );
    }

    protected function getId(): string
    {
        return (string) 1;
    }

    protected function getStatus(): string
    {
        return 'pending';
    }

    protected function getAmount()
    {
        $currency = Currencies::where('code', $this->order->getCart()->getCurrencyCode())->first();
        $total = $this->order->getCart()->getTotal();

        return [
            'value' => number_format($total->getValue(), $currency->precision, '.', ''),
            'currency' => $currency->code
        ];
    }

    protected function getConfirmation()
    {
        return [
            'type' => 'redirect',
            'return_url' => siteUrl('/checkout/thanks/' . $this->order->getId())
        ];
    }

    protected function getDescription(): string
    {
        return trans('shop.payment.title', [
            'orderId' => $this->order->getId()
        ]);
    }

    protected function getIdempotencyKey()
    {

        return uniqid('', true);
    }
}
