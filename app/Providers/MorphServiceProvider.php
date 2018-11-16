<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class MorphServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'product'        => \App\Models\Shop\Product\Product::class,
            'category'       => \App\Models\Shop\Category\Category::class,
            'room'           => \App\Models\Shop\Room\Room::class,
            'style'          => \App\Models\Shop\Style\Style::class,
            'review'         => \App\Models\Review::class,
            'city'           => \App\Models\City::class,
            'region'         => \App\Models\Region::class,
            'payment_yandex' => \App\Models\Shop\Payment\YandexPayment::class,
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
