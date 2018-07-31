<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\OrderProduct as BaseOrderProduct;

class OrderProduct extends BaseOrderProduct
{
    protected $fillable = [
        'order_id',
        'product_id',
        'default_price',
        'final_price',
        'quantity',
        'params'
    ];

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
