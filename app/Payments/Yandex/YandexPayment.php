<?php

namespace App\Payments\Yandex;

use Illuminate\Http\Request;
use YandexCheckout\Client;
use Exception;
use Currencies;

class YandexPayment
{
    protected $shopId = null;
    protected $shopPassword = null;
    protected $secretKey = null;
    protected $order = null;

    public function __construct($order = null)
    {
        $this->shopId       = env('YANDEX_PAYMENT_SHOP_ID');
        $this->shopPassword = env('YANDEX_PAYMENT_SHOP_PASSWORD');
        $this->secretKey    = env('YANDEX_PAYMENT_SECRET_KEY');

        $this->setOrder($order);
    }

    public function setOrder($order = null)
    {
        $this->order = $order;
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
        try {
            $client = $this->getClient();

            $response = $client->createPayment(
                [
                    'amount'       => $this->getAmount(),
                    'confirmation' => $this->getConfirmation(),
                    'description'  => $this->getDescription(),
                ],
                $this->getIdempotencyKey()
            );
        }
        catch (Exception $e) {
            dd($e);
        }

        dd($response);
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
        $currency = Currencies::where('code', $this->order->cart->getCurrencyCode());
        $total = $this->order->cart->getTotal();

        return [
            number_format($total->value, $currency->precision, '.', ''),
            $currency->code
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
        return trans('Оплата заказа № %%', [
            'orderId' => $this->order->getId()
        ]);
    }

    protected function getIdempotencyKey()
    {

        return uniqid('', true);
    }

    protected function checkHash(Request $request)
    {
        $innerHash = join(';', [
            $request->input('action'),
            $request->input('orderSumAmount'),
            $request->input('orderSumCurrencyPaycash'),
            $request->input('orderSumBankPaycash'),
            $this->shopId,
            $request->input('invoiceId'),
            $request->input('customerNumber'),
            $this->shopPassword
        ]);

        return md5($innerHash) === $incomingHash;
    }
}
