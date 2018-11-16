<?php

namespace App\Models\Shop\Payment;

use MosseboShopCore\Models\Shop\Payment\Payment as BasePayment;
use App\Models\Shop\Order\Order;

class Payment extends BasePayment
{
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
