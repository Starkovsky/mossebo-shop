<?php

namespace App\Http\Controllers\Shop;

use Cart;
use Mail;
use PayTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;

use App\Shop\Order\OrderSaver;
use App\Mail\Checkout as CheckoutMail;

class CheckoutController extends Controller
{
    public function index(CheckoutRequest $request)
    {
        $result = (new OrderSaver($request->all()))->save();

        Mail::to($result['email'])
            ->bcc(config('mail.to.address'), config('mail.to.name'))
            ->queue(new CheckoutMail($result));

        Cart::clear()->save();

        return response([
            'status'  => 'success',
            'orderId' => $result['id']
        ], 200);
    }
}

