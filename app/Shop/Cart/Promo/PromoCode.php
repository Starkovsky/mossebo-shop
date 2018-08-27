<?php

namespace App\Shop\Cart\Promo;

use MosseboShopCore\Shop\Cart\Promo\PromoCode as BasePromoCode;
use MosseboShopCore\Contracts\Shop\Cart\Promo\PromoCode as PromoCodeInterface;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;

class PromoCode extends BasePromoCode implements PromoCodeInterface
{
    public function setResource($codeName = ''): void
    {
        $this->resource = PromoCodeModel::where('name', $codeName)->first();
    }
}
