<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('categories', function() {
            return app()->make(\App\Repositories\CategoryRepository::class);
        });

        $this->app->singleton('languages', function() {
            return app()->make(\App\Repositories\LanguageRepository::class);
        });

        $this->app->singleton('attributes', function() {
            return app()->make(\App\Repositories\AttributeRepository::class);
        });


        $this->app->singleton('rooms', function() {
            return new \MosseboShopCore\Repositories\RoomRepository(
                \App\Models\Shop\Room::class
            );
        });

        $this->app->singleton('styles', function() {
            return new \MosseboShopCore\Repositories\StyleRepository(
                \App\Models\Shop\Style::class
            );
        });

        $this->app->singleton('currencies', function() {
            return new \MosseboShopCore\Repositories\CurrencyRepository(
                \App\Models\Shop\Currency::class
            );
        });

        $this->app->singleton('delivery-types', function() {
            return new \MosseboShopCore\Repositories\LanguageRepository(
                \App\Models\Shop\DeliveryType::class
            );
        });

//        $this->app->singleton('price-types', function() {
//            return new \MosseboShopCore\Repositories\PriceTypeRepository(
//                \App\Models\Shop\PriceType::class
//            );
//        });

        $this->app->singleton('pay-types', function() {
            return new \MosseboShopCore\Repositories\LanguageRepository(
                \App\Models\Shop\PayType::class
            );
        });

        $this->app->singleton('order-statuses', function() {
            return new \MosseboShopCore\Repositories\LanguageRepository(
                \App\Models\Shop\OrderStatus::class
            );
        });

        $this->app->singleton('cities', function() {
            return new \MosseboShopCore\Repositories\CityRepository(
                \App\Models\City::class
            );
        });

        $this->app->singleton('countries', function() {
            return new \MosseboShopCore\Repositories\CountryRepository(
                \App\Models\Country::class
            );
        });

        $this->app->singleton('settings', function() {
            return new \MosseboShopCore\Repositories\SettingsRepository(
                \App\Models\Settings::class
            );
        });

        $this->app->singleton('badge-types', function() {
            return new \MosseboShopCore\Repositories\BadgeTypeRepository(
                \App\Models\Shop\Badge\BadgeType::class
            );
        });

        $this->app->singleton('banner-places', function() {
            return new \MosseboShopCore\Repositories\BannerPlaceRepository(
                \App\Models\Shop\Banner\BannerPlace::class
            );
        });
    }
}
