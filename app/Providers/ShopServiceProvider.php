<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use App\Shop\Cart\CartProxy;

use MosseboShopCore\Shop\Cart\Cart;
use MosseboShopCore\Contracts\Shop\Cart\Cart as CartInterface;

use App\Shop\Cart\CartProduct;
use MosseboShopCore\Contracts\Shop\Cart\CartProduct as CartProductInterface;

use MosseboShopCore\Shop\Cart\CartProductData;
use MosseboShopCore\Contracts\Shop\Cart\CartProductData as CartProductDataInterface;

use App\Shop\Price;
use MosseboShopCore\Contracts\Shop\Price as PriceInterface;

use App\Shop\Cart\Promo\PromoCode;
use MosseboShopCore\Contracts\Shop\Cart\Promo\PromoCode as PromoCodeInterface;

use MosseboShopCore\Shop\Cart\Builders\SessionCartLoader;
use MosseboShopCore\Shop\Cart\Savers\SessionCartSaver;

use MosseboShopCore\Shop\Cart\Builders\DatabaseCartLoader;
use App\Shop\Cart\Savers\DatabaseCartSaver;

use MosseboShopCore\Shop\Order\Order;
use MosseboShopCore\Contracts\Shop\Order\Order as OrderInterface;

use MosseboShopCore\Shop\Shipping\Shipping;
use MosseboShopCore\Contracts\Shop\Shipping\Shipping as ShippingInterface;

use MosseboShopCore\Shop\Payment\Payment;
use MosseboShopCore\Contracts\Shop\Payment\Payment as PaymentInterface;

use MosseboShopCore\Shop\Customer;
use MosseboShopCore\Contracts\Shop\Customer as CustomerInterface;

use App\Shop\Shop as BaseShop;
use Session;
use Shop;

class ShopServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('shop', function() {
            return new BaseShop;
        });

        $this->app->bind(PriceInterface::class, Price::class);

        // cart
        $this->app->bind(CartInterface::class, Cart::class);
        $this->app->bind(CartProductInterface::class, CartProduct::class);
        $this->app->bind(CartProductDataInterface::class, CartProductData::class);
        $this->app->bind(PromoCodeInterface::class, PromoCode::class);

        // order
        $this->app->bind(OrderInterface::class, Order::class);
        $this->app->bind(ShippingInterface::class, Shipping::class);
        $this->app->bind(PaymentInterface::class, Payment::class);
        $this->app->bind(CustomerInterface::class, Customer::class);

        $this->app->singleton('cart', function() {
            $customer = Shop::getCustomer();

            if ($customer) {
                $dbCart = $this->makeDataBaseCart($customer);
                $proxy = new CartProxy($dbCart, $saver = app()->make(DatabaseCartSaver::class, [
                    'cart' => $dbCart
                ]));

                if ($dbCart->isEmpty()) {
                    $sessionCart = $this->makeSessionCart();

                    if (! $sessionCart->isEmpty()) {
                        $this->mergeCarts($dbCart, $sessionCart);
                        $proxy->save();
                    }
                }

                return $proxy;
            }


            $sessionCart = isset($sessionCart) ? $sessionCart : $this->makeSessionCart();

            $saver = app()->make(SessionCartSaver::class, [
                'cart' => $sessionCart
            ]);

            $saver->setStoreKey($this->getSessionCartKey());

            return new CartProxy($sessionCart, $saver);
        });

        $this->registerFacade();
    }

    protected function registerFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Cart', '\App\Support\Facades\Cart');
    }

    protected function getSessionCartKey()
    {
        return implode('::', [
            'mossebo-shop',
            'cart',
        ]);
    }

    protected function makeDataBaseCart($customer)
    {
        dd(Shop::makeCart(DatabaseCartLoader::class, $customer->getCart()));
        return Shop::makeCart(DatabaseCartLoader::class, $customer->getCart());
    }
//
    protected function makeSessionCart()
    {
        return Shop::makeCart(SessionCartLoader::class, Session::get(
            $this->getSessionCartKey()
        ));
    }

    protected function mergeCarts($mainCart, $cart)
    {
        $mainCart->init(function($mainCart) use($cart) {
            $mainCart->setProducts($cart->getProducts());
            $mainCart->setCurrencyCode($cart->getCurrencyCode());

            if ($promoCode = $cart->getPromoCode()) {
                $mainCart->setPromoCode($promoCode);
            }
        });
    }
}
