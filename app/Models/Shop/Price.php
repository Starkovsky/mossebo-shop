<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Price as BasePrice;

class Price extends BasePrice
{
    public function type()
    {
        return $this->hasOne(PriceType::class, 'price_type_id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'item');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public static function formatPrice($value, $currencyCode)
    {
        $price = new static;

        $price->value = $value;
        $price->currency_code = $currencyCode;

        return $price->getFormatted();
    }

    public static function getPriceValue($value, $currencyCode)
    {
        $price = new static;

        $price->value = $value;
        $price->currency_code = $currencyCode;

        return $price->getValue();
    }
}
