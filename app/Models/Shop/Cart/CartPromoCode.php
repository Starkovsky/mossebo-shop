<?php

namespace App\Models\Shop\Cart;

use MosseboShopCore\Models\Shop\Cart\CartPromoCode as BaseCartPromoCode;
use App\Models\Shop\Promo\PromoCode;

class CartPromoCode extends BaseCartPromoCode
{
    public function cart()
    {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }

    public function promoCode()
    {
        return $this->hasOne(PromoCode::class, 'id', 'promo_code_id');
    }
}
