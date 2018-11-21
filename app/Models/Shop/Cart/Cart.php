<?php

namespace App\Models\Shop\Cart;

use MosseboShopCore\Models\Shop\Cart\Cart as BaseCart;
use App\Models\Shop\Currency\Currency;
use App\Models\Shop\Promo\PromoCode;
use App\Models\User;

class Cart extends BaseCart
{
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, $this->relationFieldName, 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'code', 'currency_code');
    }

    public function promoCodeRelation()
    {
        return $this->hasOne(CartPromoCode::class, $this->relationFieldName, 'id');
    }

    public function promoCode()
    {
        return $this->hasManyThrough(
            PromoCode::class, CartPromoCode::class,
            $this->relationFieldName, 'id', 'id', 'promo_code_id'
        );
    }
}
