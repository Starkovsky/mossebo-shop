<?php

namespace App\Shop;

use Route;
use App\Shop\Cart\Promo\PromoCode;
use MosseboShopCore\Shop\Shop as BaseShop;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;

class Shop extends BaseShop
{
    protected $route = null;

    public function getDefaultPromoCode()
    {
        $defaultPromoCodeId = config('shop.promo.default');

        if (! $defaultPromoCodeId) {
            return false;
        }

        $promoCodeResource = PromoCodeModel::where('id', $defaultPromoCodeId)->first();

        if (! $promoCodeResource) {
            return false;
        }

        return new PromoCode($promoCodeResource);
    }

    protected function getCurrentRoute()
    {
        if (is_null($this->route)) {
            $this->route = Route::getCurrentRoute();
        }

        return $this->route;
    }

    public function isMainPage()
    {
        return $this->getCurrentRoute()->getName() === 'home';
    }

    public function isCatalog()
    {
        return in_array($this->getCurrentRoute()->getName(), [
            'catalog',
            'catalog-category',
            'room-catalog',
            'room-category',
            'style-catalog',
            'style-category',
        ]);
    }
}
