<?php

namespace App\Http\Controllers\Shop;

use DB;
use Shop;
use Cart;
use Mail;
use PayTypes;
use Session;
use MosseboShopCore\Contracts\Shop\Order\Order as OrderInterface;
use MosseboShopCore\Shop\Order\Builders\CheckoutOrderBuilder;
use MosseboShopCore\Shop\Order\Builders\ModelOrderBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Controllers\ContentController;

use App\Http\Resources\OrderResource;


use App\Shop\Order\OrderSaver;
use App\Mail\Checkout as CheckoutMail;
use App\Payments\Yandex\YandexPayment;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Payment\Payment;
use App\Models\Shop\Payment\YandexPayment as YandexPaymentDetails;

class CheckoutController extends Controller
{
    public function index(CheckoutRequest $request)
    {
        $order = Shop::makeOrder(CheckoutOrderBuilder::class, $request->all());

        try {
            $confirmationLink = $this->handleNewOrder($order);
        }
        catch(\Exception $e) {
            dd($e);
            return response([
                'status'   => 'error',
                'message' => trans('errors.default')
            ], 500);
        }

        if (Cart::hasCustomer()) {
            Cart::clear()->save();
        }
        else {
            $orders = Session::get('orders', []);
            $orders[] = $order->getId();
            Session::put('orders', $orders);
        }

        return response([
            'status'   => 'success',
            'orderId'  => $order->getId(),
            '_redirect' => $confirmationLink
        ], 200);
    }

    protected function handleNewOrder(OrderInterface $order)
    {
        return DB::transaction(function() use ($order) {
            (new OrderSaver($order))->save();
            $confirmationLink = $this->makePayment($order);

            $this->sendEmail($order);

            return $confirmationLink;
        });
    }

    protected function sendEmail($order)
    {
        Mail::to($order->getCustomer()->getAttribute('email'))
            ->bcc(config('mail.default_to.address'), config('mail.default_to.name'))
            ->queue(new CheckoutMail($order));
    }

    protected function makePayment(OrderInterface $order)
    {
        $response = (new YandexPayment($order))->sendRequest();
        $amount = $response->getAmount();

        $details = new YandexPaymentDetails([
            'yandex_payment_id' => $response->getId(),
            'currency_code'     => $amount->getCurrency(),
            'amount'            => $amount->getValue(),
            'status'            => 'pending'
        ]);

        $details->save();

        $details->payment()->save(new Payment([
            'order_id' => $order->getId(),
        ]));

        return $response->getConfirmation()->getConfirmationUrl();
    }

    public function thanks($orderId)
    {
        $this->userHasAccessToOrderOrFail(Order::findOrFail($orderId));

        $data = [
            'orderId' => $orderId,
        ];

        // todo: доделать при изменении системы контента
        foreach (['delivery', 'pay', 'garant'] as $item) {
            $data[$item] = ContentController::getHelpContent($item);
        }

        if (! Cart::hasCustomer()) {
            Cart::clear()->save();
        }

        return view('shop.pages.checkout.thanks', $data);
    }

    public function order($orderId = null)
    {
        $order = Order::with([
            'user',
            'PromoUse',
            'orderProducts',
            'payment',
            'status',
        ])
            ->findOrfail($orderId);

        $this->userHasAccessToOrderOrFail($order);

        return view('shop.pages.checkout.order', [
            'order' => new OrderResource($order),
            'orderId' => $orderId
        ]);
    }

    protected function userHasAccessToOrderOrFail($order)
    {
        if ($user = Shop::getCustomer()) {
            if ($order->user_id !== $user->id) {
                abort(404);
            }
        }
        else {
            $orders = Session::get('orders', []);

            if (! in_array($order->id, $orders)) {
                abort(404);
            }
        }
    }

    public function pay($orderId)
    {
        $order = Order::with([
            'user',
            'PromoUse',
            'orderProducts',
            'payment',
            'status',
        ])
            ->findOrfail($orderId);

        $this->userHasAccessToOrderOrFail($order);

        $order = Shop::makeOrder(ModelOrderBuilder::class, $order);

        return redirect($this->makePayment($order));
    }
}
