<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\OrderProductAttributeOption as BaseOrderProductAttributeOption;

class OrderProductAttributeOption extends BaseOrderProductAttributeOption
{
    protected $fillable = [
        'order_product_id',
        'option_id',
    ];

    public $timestamps = false;
}
