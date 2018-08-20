<?php

namespace App\Shop\Cart;

use MosseboShopCore\Shop\Cart\CartProduct as BaseCartProduct;
use MosseboShopCore\Contracts\Shop\Cart\CartProductData as CartProductDataInterface;
use App\Models\Shop\Product;

class CartProduct extends BaseCartProduct
{
    protected static function findCartProductData($id, $options = []): ?CartProductDataInterface
    {
        return Product::getCartItem($id, $options);
    }
}
