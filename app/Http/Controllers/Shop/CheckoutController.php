<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Requests\Checkout\EmailRequest;
use App\Http\Requests\Checkout\PhoneRequest;

use App\Models\Shop\OrderTemp;
use App\Cart\CartProxy;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    // todo: ДОПИЛИТЬ ВСЕ!!!
    public function index(CheckoutRequest $request)
    {
        $data = $request->all();

        $result = [
            'cart' => [],
            'shipping' => [
                'data' => $data['shipping']['data'],
                'type' => $data['shipping']['type'] === 'free' ? 'Бесплатная доставка' : 'Экспресс доставка',
            ],
        ];

        $total = 0;

        foreach ($data['cart'] as $key => $qty) {
            $product = CartProxy::getProductInfo($key);
            $price = $product->prices->where('price_type_id', 2)->first();

            $result['cart'][] = [
                'product' => $product,
                'qty' => $qty
            ];

            $total += $price->value;
        }

        $price = clone $price;
        $price->value = $total;

        $result['total'] = $price->getFormatted();

        $result['payment'] = $data['payment'] === 'yandex_payment' ? 'Сервис Яндекс.Платежка.' : 'Оплата при получении.';

        $order = (new OrderTemp([
            'data' => json_encode($result, JSON_UNESCAPED_UNICODE)
        ]))->save();

        $result['orderId'] = $order;
        Mail::send('emails.checkout.test', $result, function ($message) use($result) {

            $message->from('shop@mossebo.market', 'Mossebo Market');
            $message->to('vlad.starkovsky@gmail.com', 'Владислав')->subject('Заказ с сайта Mossebo.Market');
            $message->cc($result['shipping']['data']['email'])->subject('Заказ с сайта Mossebo.market');

        });

        return response(null, 200);
    }

    public function email(EmailRequest $request)
    {
        return response(null, 200);
    }

    public function phone(PhoneRequest $request)
    {
        return response(null, 200);
    }
}

