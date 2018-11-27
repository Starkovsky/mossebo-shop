<?php

namespace App\Payments\Yandex;

use Illuminate\Http\Request;
use MosseboShopCore\Contracts\Shop\Cart\CartProduct;
use YandexCheckout\Client;
use Exception;
use Currencies;
use MosseboShopCore\Contracts\Shop\Order\Order;
use Shop;

class YandexPayment
{
    protected $shopId = null;
    protected $secretKey = null;
    protected $order = null;
    protected $currency = null;

    public function __construct(Order $order = null)
    {
        $this->shopId    = env('YANDEX_PAYMENT_SHOP_ID');
        $this->secretKey = env('YANDEX_PAYMENT_SECRET_KEY');

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
                'receipt'      => $this->getReceipt()
            ],
            $this->getIdempotencyKey()
        );
    }

    protected function getReceipt()
    {
        $customer = $this->order->getCustomer();

        return [
            'phone' => $this->preparePhone($customer->getAttribute('phone')),
            'email' => $customer->getAttribute('email'),
            'items' => $this->getReceiptItems()
        ];

    }

    protected function preparePhone($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }

    protected function getReceiptItems(): array
    {
        $languageCode = Shop::getCurrentLanguage()->code;
        $currency = $this->getCurrency();

        return $this->order->getCart()->getProducts()->map(function(CartProduct $product) use($languageCode, $currency) {
            return [
                'description' => $product->getTitle($languageCode),
                'quantity' => $product->getQuantity(),
                'amount' => [
                    'value' => $this->preparePrice($product->getFinalPrice()->getValue(), $currency->precision),
                    'currency' => $currency->code,
                ],
                // todo: перенести в env?
                'vat_code' => 1
            ];
        })->toArray();
    }

    protected function getId(): string
    {
        return (string) 1;
    }

    protected function getStatus(): string
    {
        return 'pending';
    }

    protected function getCurrency()
    {
        if (is_null($this->currency)) {
            $this->currency = Currencies::where('code', $this->order->getCart()->getCurrencyCode())->first();
        }

        return $this->currency;
    }

    protected function getAmount()
    {
        $currency = $this->getCurrency();
        $total = $this->order->getCart()->getTotal();

        return [
            'value' => $this->preparePrice($total->getValue(), $currency->precision),
            'currency' => $currency->code
        ];
    }

    protected function preparePrice($price, $precision)
    {
        return number_format($price, $precision, '.', '');
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
