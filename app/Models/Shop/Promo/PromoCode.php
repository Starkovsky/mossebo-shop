<?php

namespace App\Models\Shop\Promo;

use MosseboShopCore\Models\Shop\Promo\PromoCode as BasePromoCode;
use App\Support\Traits\Models\HasI18n;

class PromoCode extends BasePromoCode
{
    use HasI18n;

    public function conditions()
    {
        return $this->hasMany(PromoCondition::class, $this->relationFieldName, 'id');
    }

    public function uses()
    {
        return $this->hasMany(PromoUse::class, $this->relationFieldName, 'id');
    }
}
