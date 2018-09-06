<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\OrderProduct as BaseOrderProduct;

class OrderProduct extends BaseOrderProduct
{
    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function options()
    {
        return $this->hasMany(OrderProductAttributeOption::class, 'order_product_id', 'id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
