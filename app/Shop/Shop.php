<?php

namespace App\Shop;

use Auth;
use MosseboShopCore\Contracts\Shop\Cart\Cart;
use MosseboShopCore\Contracts\Shop\Customer;
use Route;
use MosseboShopCore\Shop\Shop as BaseShop;
use MosseboShopCore\Contracts\Shop\Cart\Promo\PromoCode as PromoCodeInterface;
use App\Models\Shop\Promo\PromoCode as PromoCodeModel;
use App\Models\Shop\Product\ProductAttributeOption;


class Shop extends BaseShop
{
    protected $route = null;
    protected $customer = null;

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

        return $this->make(PromoCodeInterface::class, [
            'codeName' => $promoCodeResource
        ]);
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

    public function getCustomer(): ?Customer
    {
        if (is_null($this->customer)) {
            $prefix = app('request')->route()->getPrefix();

            if (strpos($prefix, 'api/') === 0) {
                $this->customer = Auth::guard('api')->user();
            }
            else {
                $this->customer = Auth::user();
            }
        }

        return $this->customer;
    }

    public function isFranchiseeDomain()
    {
        return strpos(request()->getHost(), 'f.') === 0;
    }

    public function customerIsFranchisee()
    {
        $customer = $this->getCustomer();

        return $customer && $customer->isFranchisee();
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

    public function getAvailableProductOptionIds($productId): array
    {
        $options = ProductAttributeOption::select('option_id')->where('product_id', $productId)->get();

        return array_column($options->toArray(), 'option_id');
    }
}
