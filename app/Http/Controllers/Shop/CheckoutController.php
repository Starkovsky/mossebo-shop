<?php

namespace App\Http\Controllers\Shop;

use DB;
use Auth;
use Mail;
use PayTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;

use Cart;
use App\Models\Shop\Product;
use App\Models\Shop\Order;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\OrderProductAttributeOption;
use App\Models\Shop\AttributeOption;
use App\Mail\Checkout as CheckoutMail;

class CheckoutController extends Controller
{
    public function index(CheckoutRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $currencyCode = 'RUB';

        $result = [
            'language_code'    => app()->getLocale(),
            'order_status_id'  => 1,
            'pay_type_id'      => $data['pay_type'],
            'delivery_type_id' => $data['shipping']['type'],
            'currency_code'    => $currencyCode,
            'first_name'       => $data['shipping']['data']['first_name'],
            'last_name'        => $data['shipping']['data']['last_name'],
            'city'             => $data['shipping']['data']['city'],
            'address'          => $data['shipping']['data']['address'],
            'email'            => $data['shipping']['data']['email'],
            'phone'            => $data['shipping']['data']['phone'],
            'post_code'        => $data['shipping']['data']['post_code'],
            'comment'          => $data['shipping']['data']['comment'],
            'cart'             => []
        ];

        if ($user) {
            $result['user_id'] = $user->id;
        }

        $ids = [];
        $productItems = [];
        $options = [];

        foreach ($data['cart'] as $key => $qty) {
            $decoded = Cart::decodeKey($key);

            $ids[] = $decoded['id'];
            $productItems[$decoded['id']] = [
                'options' => $decoded['options'],
                'qty' => $qty
            ];

            $options = array_merge($options, $decoded['options']);
        }

        $options = AttributeOption::whereIn('id', $options)
            ->with('currentI18n')
            ->get();

        $products = Product::whereIn('id', $ids)
            ->with('prices', 'image', 'currentI18n')
            ->get();

        $defaultPriceType = config('shop.price.types.default');
        $finalPriceType = $this->getUserPriceType($user);

        $defaultAmount = 0;
        $finalAmount = 0;

        DB::transaction(function() use(& $result, &$defaultAmount, &$finalAmount, $products, $productItems, $defaultPriceType, $finalPriceType, $options, $currencyCode) {
            $order = new Order($result);

            $order->save();

            $result['id'] = $order->id;

            foreach ($products as $product) {
                $defaultPrice = $product->prices->where('price_type_id', $defaultPriceType)
                    ->where('currency_code', $currencyCode)
                    ->first();

                $finalPrice = $product->prices->where('price_type_id', $finalPriceType)
                    ->where('currency_code', $currencyCode)
                    ->first();

                if (! $finalPrice) {
                    $finalPrice = $defaultPrice;
                }

                $defaultAmount += $defaultPrice->value;
                $finalAmount += $finalPrice->value;

                $result['cart'][] = [
                    'product'       => $product,
                    'defaultPrice'  => $defaultPrice->value,
                    'finalPrice'    => $finalPrice->value,
                    'quantity'      => $productItems[$product->id]['qty'],
                    'options'       => $options->whereIn('id', $productItems[$product->id]['options'])
                ];

                $orderProduct = new OrderProduct([
                    'order_id'      => $result['id'],
                    'product_id'    => $product->id,
                    'currency_code' => $currencyCode,
                    'default_price' => $defaultPrice->value,
                    'final_price'   => $finalPrice->value,
                    'quantity'      => $productItems[$product->id]['qty'],
                    'params'        => json_encode([
                        'image'       => $product->image->toArray(),
                        'currentI18n' => $product->currentI18n->toArray(),
                        'prices'      => $product->prices->where('currency_code', $currencyCode)->toArray(),
                    ], JSON_UNESCAPED_UNICODE)
                ]);

                $orderProduct->save();

                foreach ($productItems[$product->id]['options'] as $optionId) {
                    $orderProduct->options()->save(new OrderProductAttributeOption([
                        'option_id' => $optionId,
                    ]));
                }
            }
        });

        $result['defaultAmount'] = formatPrice($defaultAmount, $currencyCode);
        $result['finalAmount'] = formatPrice($finalAmount, $currencyCode);

        $payType = PayTypes::enabled('currentI18n')->where('id', $result['pay_type_id'])->first();

        $result['pay_type'] = $payType->currentI18n->name;

        Mail::to($result['email'])
            ->bcc(config('mail.to.address'), config('mail.to.name'))
            ->queue(new CheckoutMail($result));

        Cart::clear()->save();

        return response([
            'status'  => 'success',
            'orderId' => $result['id']
        ], 200);
    }

    protected function getUserPriceType($user = null)
    {
        if ($user && isset($user->price_type_id) && $user->price_type_id) {
            return $user->price_type_id;
        }

        return config('shop.price.types.default');
    }
}

