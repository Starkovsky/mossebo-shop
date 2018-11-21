<?php

namespace App\Models\Shop\Cart;

use MosseboShopCore\Models\Shop\Cart\CartProduct as BaseCartProduct;
use App\Models\Shop\Product\Product;

class CartProduct extends BaseCartProduct
{
    public function cart()
    {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }

    public function options()
    {
        return $this->hasMany(CartProductAttributeOption::class, $this->relationFieldName, 'id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
