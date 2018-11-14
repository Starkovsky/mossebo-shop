<?php

namespace App\Shop\Order;

use DB;
use Cart;
use Shop;
use PayTypes;
use App\Models\Shop\Order\Order;
use App\Models\Shop\Order\OrderProduct;
use App\Models\Shop\Order\OrderProductAttributeOption;
use App\Models\Shop\Promo\PromoUse;

use MosseboShopCore\Contracts\Shop\Order\Order as OrderInterface;

class OrderSaver
{
    protected $order = null;

    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function save()
    {
        DB::transaction(function() {
            $orderModel = new Order($this->order->toStore());
            $orderModel->save();

            $this->order->setId($orderModel->id);

            $this->savePromo($orderModel);
            $this->saveProducts($orderModel);
        });
    }

    protected function savePromo($orderModel)
    {
        $promoCode = $this->order->getCart()->getPromoCode();

        if (is_null($promoCode)) {
            return;
        }

        $data = [
            'promo_code_id' => $promoCode->id,
            'amount'        => $promoCode->amount,
            'percent'       => $promoCode->percent,
            'currency_code' => $promoCode->currency_code,
        ];

        if ($userId = $this->order->getCustomer()->getId()) {
            $data['user_id'] = $userId;
        }

        $orderModel->promoUse()->save(new PromoUse($data));
    }

    protected function saveProducts($orderModel)
    {
        foreach ($this->order->getCart()->getProducts() as $product) {
            $orderProduct = new OrderProduct($product->toStore(true));

            $orderModel->orderProducts()->save($orderProduct);

            foreach ($product->getOptions() as $optionId) {
                $orderProduct->options()->save(new OrderProductAttributeOption([
                    'option_id' => $optionId,
                ]));
            }
        }
    }
}
