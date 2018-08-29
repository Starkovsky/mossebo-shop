<?php

namespace App\Models\Shop\Promo;

use MosseboShopCore\Models\Shop\Promo\PromoUse as BasePromoUse;
use App\Models\User;

class PromoUse extends BasePromoUse
{
    protected $fillable = [
        'promo_code_id',
        'user_id',
        'order_id',
        'amount',
        'percent',
        'currency_code',
    ];

    public function code()
    {
        return $this->hasOne(PromoCode::class, 'id', 'promo_code_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
