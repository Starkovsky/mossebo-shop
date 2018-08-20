<?php

namespace App\Shop\Cart\Promo;

use MosseboShopCore\Shop\Promo\PromoCode as BasePromoCode;
use MosseboShopCore\Contracts\Shop\Promo\PromoCode as PromoCodeInterface;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;

class PromoCode extends BasePromoCode implements PromoCodeInterface
{
    public function setResource($codeName = ''): void
    {
        $this->resource = PromoCodeModel::where('name', $codeName)->first();
    }
}
