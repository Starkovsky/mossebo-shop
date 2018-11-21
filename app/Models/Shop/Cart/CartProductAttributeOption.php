<?php

namespace App\Models\Shop\Cart;

use MosseboShopCore\Models\Shop\Cart\CartProductAttributeOption as BaseCartProductAttributeOption;
use App\Models\Shop\Product\ProductAttributeOption;

class CartProductAttributeOption extends BaseCartProductAttributeOption
{
    public function cartProduct()
    {
        return $this->hasOne(CartProduct::class, 'id', 'cart_product_id');
    }

    public function option()
    {
        return $this->hasOne(ProductAttributeOption::class, 'id', 'option_id');
    }
}
