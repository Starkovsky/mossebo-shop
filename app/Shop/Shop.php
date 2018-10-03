<?php

namespace App\Shop;

use Auth;
use Route;
use App\Shop\Cart\Promo\PromoCode;
use MosseboShopCore\Shop\Shop as BaseShop;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;

class Shop extends BaseShop
{
    protected $route = null;
    protected $user = null;

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

    public function user()
    {
        if (is_null($this->user)) {
            $prefix = app('request')->route()->getPrefix();

            if (strpos($prefix, 'api/') === 0) {
                $this->user = Auth::guard('api')->user();
            }
            else {
                $this->user = Auth::user();
            }
        }

        return $this->user;
    }

    public function isFranchiseeDomain()
    {
        return strpos(request()->getHost(), 'f.') === 0;
    }

    public function userIsFranchisee()
    {
        $user = $this->user();

        return $user && $user->isFranchisee();
    }

    public function isFranchisee()
    {
        return $this->isFranchiseeDomain() && $this->userIsFranchisee();
    }

    public function getCurrentPriceTypeId()
    {
        if ($this->isFranchisee()) {
            return config('shop.price.types.franchisee');
        }

        return $this->getDefaultPriceTypeId();
    }








    protected $salesHandler = null;

    public function sales()
    {
        if (is_null($this->salesHandler)) {
            $this->salesHandler = new \App\Shop\Sale\Sale();
        }

        return $this->salesHandler;
    }
}
