<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


use App\Shop\Cart\CartProxy;

use MosseboShopCore\Shop\Cart\Cart;
use MosseboShopCore\Contracts\Shop\Cart\Cart as CartInterface;

use App\Shop\Cart\CartProduct;
use MosseboShopCore\Contracts\Shop\Cart\CartProduct as CartProductInterface;

use App\Shop\Price;
use MosseboShopCore\Contracts\Shop\Price as PriceInterface;

use MosseboShopCore\Shop\Cart\Storage\Session\CartSessionLoader;
use MosseboShopCore\Shop\Cart\Storage\Session\CartSessionSaver;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind(PriceInterface::class, Price::class);
        $this->app->bind(CartInterface::class, Cart::class);
        $this->app->bind(CartProductInterface::class, CartProduct::class);

        $this->app->singleton('cart', function() {
            $cart = app()->make(CartSessionLoader::class);
            $cart = $cart->getCart();

            return new CartProxy(
                $cart,
                app()->make(CartSessionSaver::class)
            );
        });

        $this->registerFacade();
    }

    protected function registerFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Cart', '\App\Support\Facades\Cart');
    }
}
