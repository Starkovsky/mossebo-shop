<?php

namespace App\Models\Shop\Order;

use MosseboShopCore\Models\Shop\Order\OrderStatus as BaseOrderStatus;
use App\Support\Traits\Models\HasI18n;

class OrderStatus extends BaseOrderStatus
{
    use HasI18n;
}
