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
            'product'  => \App\Models\Shop\Product::class,
            'category' => \App\Models\Shop\Category::class,
            'room'     => \App\Models\Shop\Room::class,
            'style'    => \App\Models\Shop\Style::class,
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
