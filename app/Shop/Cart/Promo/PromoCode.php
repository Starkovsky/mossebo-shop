<?php

namespace App\Shop\Cart\Promo;

use MosseboShopCore\Shop\Cart\Promo\PromoCode as BasePromoCode;
use MosseboShopCore\Contracts\Shop\Cart\Promo\PromoCode as PromoCodeInterface;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;

class PromoCode extends BasePromoCode implements PromoCodeInterface
{
    public function setResource($codeIdOrName = ''): void
    {
        if (is_int($codeIdOrName)) {
            $resource = PromoCodeModel::where('id', $codeIdOrName)->first();

            if ($resource) {
                $this->resource = $resource;
                return;
            }
        }

        $this->resource = PromoCodeModel::where('name', $codeIdOrName)->first();
    }
}
