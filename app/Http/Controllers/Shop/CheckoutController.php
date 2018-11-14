<?php

namespace App\Http\Controllers\Shop;

use Shop;
use Cart;
use Mail;
use PayTypes;
use MosseboShopCore\Shop\Order\CheckoutOrderBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Controllers\ContentController;

use App\Shop\Order\OrderSaver;
use App\Mail\Checkout as CheckoutMail;
use App\Instagram\Instagram;

class CheckoutController extends Controller
{
    public function index(CheckoutRequest $request)
    {
        $order = Shop::makeOrder(CheckoutOrderBuilder::class, $request->all());

        (new OrderSaver($order))->save();

        Mail::to($order->getCustomer()->getAttribute('email'))
            ->bcc(config('mail.to.address'), config('mail.to.name'))
            ->queue(new CheckoutMail($order));

        if (Cart::hasCustomer()) {
            Cart::clear()->save();
        }

        return response([
            'status'  => 'success',
            'orderId' => $order->getId()
        ], 200);
    }

    public function thanks($orderId)
    {
        $data = [
            'orderId' => $orderId,
            'images' => Instagram::getLastImages('mossebo.official')->splice(0, 8)
        ];

        // todo: доделать при изменении системы контента
        foreach (['delivery', 'pay', 'garant'] as $item) {
            $data[$item] = ContentController::getHelpContent($item);
        }

        return view('shop.pages.thanks', $data);
    }
}

