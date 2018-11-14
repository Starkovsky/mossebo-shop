<?php

namespace App\Http\Controllers\RetailCRM;

use App\Http\Controllers\Controller;

use \RetailCrm\ApiClient;

use App\Models\Shop\Order\Order;
use MosseboShopCore\Shop\Cart\Storage\Model\CartModelLoader;

class BaseController extends Controller
{
    protected $url = 'https://mossebo-market2.retailcrm.ru';
    protected $apiKey = 'VRGT1NUIKO3nNLUgrCpv2NIB1FcOaXDY';

    protected $cart = null;
    protected $order = null;

    public function index()
    {
        $this->order = Order::orderBy('id', 'desc')
            ->with([
                'user',
                'language',
                'status',
                'payType',
                'deliveryType',
                'orderProducts',
                'promoUse',
            ])
            ->first();

        $this->cart = (new CartModelLoader($this->order))->getCart();

        $data = [
            'site' => 'Mossebo',
            'order' => [
                'number' => $this->order->id,
                'externalId' => $this->order->id,
                'countryIso' => 'Rus',
                'createdAt' => $this->dateFromTimestamp($this->order->created_at),
                'lastName' => $this->order->first_name,
                'firstName' => $this->order->last_name,
                'phone' => $this->order->phone,
                'email' => $this->order->email,
                'customerComment' => $this->order->comment,
            ]
        ];

        if ($discount = $this->getDiscountAmount()) {
            $data['order']['discountManualAmount'] = $discount;
        }

        if ($user = $this->cart->getUser()) {
            $data['order']['customer'] = [
                'id' => $user->id,
                'externalId' => $user->id
            ];
        }

        $products = $this->cart->getProducts();

        foreach ($products as $product) {
            $data['order']['item'][] = [
                'initialPrice' => $product->getFinalPrice(),
                'createdAt'    => $this->dateFromTimestamp($product->getAddedAtTimestamp()),
                'quantity'     => $product->getQuantity(),

            ];
        }
    }

    protected function dateFromTimestamp($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);

        return $date;
    }

    public function getDiscountAmount()
    {
        $amount = $this->cart->getAmount();
        $total = $this->cart->getProductsTotal();

        $discount = $amount->minus($total)->getValue();

        return $discount > 0 ? $discount : 0;
    }

    public function priceTypes()
    {
        $priceTypes = PriceType::localized()->get();

        foreach ($priceTypes as $priceType) {
            $data = [
                'code'        => $priceType->id,
                'name'        => $priceType->title,
                'description' => $priceType->description,
                'active'      => $priceType->enabled,
                'ordering'    => $priceType->position,
            ];

            $this->sendRequest($data);
        }
    }

    protected function sendRequest($data)
    {
        $client = new ApiClient(
            $this->url,
            $this->apiKey,
            ApiClient::V5
        );

        try {
            $response = $client->request->pricesTypesEdit($data);
        } catch (\RetailCrm\Exception\CurlException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        if ($response->isSuccessful()) {
//            dd($response);
        }
        else {
            echo dd(
                "Error: [HTTP-code %s] %s",
                $response->getStatusCode(),
                $response->getErrorMsg()
            );
        }

    }
}
