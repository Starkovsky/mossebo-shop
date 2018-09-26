<?php

namespace App\Shop\Cart;

use App\Models\Shop\Product\Product;
use MosseboShopCore\Shop\Cart\CartProduct as BaseCartProduct;
use MosseboShopCore\Contracts\Shop\Cart\CartProductData as CartProductDataInterface;

class CartProduct extends BaseCartProduct
{
    protected static function findCartProductData($id, $options = []): ?CartProductDataInterface
    {
        return Product::getCartItem($id, $options);
    }
}
