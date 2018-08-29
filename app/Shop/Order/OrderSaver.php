<?php

namespace App\Shop\Order;

use DB;
use Cart;
use PayTypes;
use App\Models\Shop\Product;
use App\Models\Shop\Order;
use App\Models\Shop\OrderProduct;
use App\Models\Shop\OrderProductAttributeOption;
use App\Models\Shop\AttributeOption;
use App\Models\Shop\Promo\PromoUse;
use Illuminate\Support\Facades\Auth;

use MosseboShopCore\Shop\Cart\Storage\Checkout\CartCheckoutLoader;

class OrderSaver
{
    protected $result           = null;
    protected $data             = null;
    protected $cart             = null;
    protected $user             = null;
    protected $currencyCode     = null;

    public function __construct($data)
    {
        $this->user         = Auth::user();
        $this->data         = $data;
        $this->currencyCode = 'RUB';
        $this->makeCart();
    }

    public function save(): array
    {
        $this->collectMainData();

        DB::transaction(function() {
            $order = $this->makeOrder();

            $this->result['id'] = $order->id;

            $this->savePromo($order);
            $this->saveProducts($order);
        });

        $baseAmount = $this->cart->getAmount();

        $this->result['baseAmount'] = $baseAmount->getFormatted();
        $this->result['finalAmount'] = $this->cart->getTotal()->getFormatted();

        $payType = PayTypes::enabled('currentI18n')->where('id', $this->result['pay_type_id'])->first();

        $this->result['pay_type'] = $payType->currentI18n->name;

        $promoCode = $this->cart->getPromoCode();

        if ($promoCode) {
            $this->result['promoPrice'] = $promoCode->getDiscountPrice($baseAmount)->getFormatted();
        }

        return $this->result;
    }

    protected function makeCart()
    {
        $this->data['currencyCode'] = $this->currencyCode;

        $cart = app()->makeWith(CartCheckoutLoader::class, [
            'data' => $this->data
        ]);

        $this->cart = $cart->getCart();
    }

    protected function makeOrder()
    {
        $order = new Order($this->result);
        $order->save();

        return $order;
    }

    protected function savePromo($order)
    {
        $promoCode = $this->cart->getPromoCode();

        if (is_null($promoCode)) {
            return;
        }

        $data = [
            'promo_code_id' => $promoCode->id,
            'amount'        => $promoCode->amount,
            'percent'       => $promoCode->percent,
            'currency_code' => $promoCode->currency_code,
        ];

        if ($this->user) {
            $data['user_id'] = $this->user->id;
        }

        $order->promoUse()->save(new PromoUse($data));
    }

    protected function saveProducts($order)
    {
        $this->result['products'] = [];

        foreach ($this->cart->getProducts() as $product) {
            $this->result['products'][] = $product;

            $orderProduct = new OrderProduct([
                'order_id'      => $order['id'],
                'product_id'    => $product->getProductId(),
                'currency_code' => $this->currencyCode,
                'default_price' => $product->getBasePrice($this->cart->getPriceTypeId(), $this->currencyCode)->getValue(),
                'final_price'   => $product->getBasePrice($this->cart->getPriceTypeId(), $this->currencyCode)->getValue(),
                'quantity'      => $product->getQuantity(),
                'params'        => json_encode([
                    'image'  => $product->getImage(),
                    'titles' => $product->getI18nTitles(),
                    'prices' => $product->getPrices(),
                ], JSON_UNESCAPED_UNICODE)
            ]);

            $order->orderProducts()->save($orderProduct);

            $orderProduct->save();

            foreach ($product->getOptions() as $optionId) {
                $orderProduct->options()->save(new OrderProductAttributeOption([
                    'option_id' => $optionId,
                ]));
            }
        }
    }

    protected function collectMainData()
    {
        $this->result = [
            'order_status_id'  => 1,
            'language_code'    => app()->getLocale(),
            'currency_code'    => $this->currencyCode,
            'price_type_id'    => $this->cart->getPriceTypeId(),
            'pay_type_id'      => $this->data['pay_type'],
            'delivery_type_id' => $this->data['shipping']['type'],
            'first_name'       => $this->data['shipping']['data']['first_name'],
            'last_name'        => $this->data['shipping']['data']['last_name'],
            'city'             => $this->data['shipping']['data']['city'],
            'address'          => $this->data['shipping']['data']['address'],
            'email'            => $this->data['shipping']['data']['email'],
            'phone'            => $this->data['shipping']['data']['phone'],
            'post_code'        => $this->data['shipping']['data']['post_code'],
            'comment'          => $this->data['shipping']['data']['comment'],
        ];

        if ($this->user) {
            $this->result['user_id'] = $this->user->id;
        }
    }
}
