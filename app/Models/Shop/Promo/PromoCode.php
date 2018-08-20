<?php

namespace App\Models\Shop\Promo;

use MosseboShopCore\Models\Shop\Promo\PromoCode as BasePromoCode;

class PromoCode extends BasePromoCode
{
    public function conditions()
    {
        return $this->hasMany(PromoCondition::class, $this->relationFieldName, 'id');
    }

    public function uses()
    {
        return $this->hasMany(PromoUse::class, $this->relationFieldName, 'id');
    }
}
