<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    public function prices()
    {
        return $this->hasMany(Price::class, 'currency_code');
    }
}
