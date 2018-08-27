<?php

namespace App\Shop;

use App\Shop\Cart\Promo\PromoCode;
use MosseboShopCore\Shop\Shop as BaseShop;
use App\Models\Shop\Promo\PromoCode as PromoCodeResource;

class Shop extends BaseShop
{
    public function getDefaultPromoCode()
    {
        $defaultPromoCodeId = config('shop.promo.default');

        if (! $defaultPromoCodeId) {
            return false;
        }

        $promoCodeResource = PromoCodeResource::where('id', $defaultPromoCodeId)->first();

        if (! $promoCodeResource) {
            return false;
        }

        return new PromoCode($promoCodeResource);
    }
}
