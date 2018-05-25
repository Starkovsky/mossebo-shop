<?php

namespace App\Cart;

use Cart;
use Session;
use App\Models\Shop\Product;
use Illuminate\Support\Collection;

class CartProxy
{
    protected static $sessionKey = 'cart-session';

    public static function get()
    {
        $items = static::getContent();

        $builded = static::addProductInfoToItems($items);

        if ($items->count() !== $builded->count()) {
            static::set($builded);
        }

        return $builded;
    }

    protected static function getContent(): Collection
    {
        return Cart::content()->map(function($item) {
            return (object) [
                'key' => $item->id,
                'qty' => $item->qty
            ];
        });
    }

    public static function add($item)
    {
        $item = (object) $item;

        if ((int) $item->qty <= 0) return;

        $info = isset($item->info) ? $item->info : static::getProductInfo($item->key);

        if ($info) {
            Cart::add([
                'id' => $item->key,
                'qty' => $item->qty,
                'name' => 'empty',
                'price' => 0
            ]);
        }
    }

    public static function set($items, $time = 0)
    {
        if (static::getSyncTime() > $time) {
            throw new \Exception('Error 389');
        }

        Cart::destroy();

        foreach ($items as $item) {
            static::add($item);
        }

        static::setSyncTime();
    }

    protected static function clear()
    {
        Cart::destroy();
        Session::forget(static::getSessionKey('sync-time'));
    }

    protected static function addProductInfoToItems(Collection $cartItems): Collection
    {
        return $cartItems->reduce(function($carry, $item) {
            $product = static::getProductInfo($item->key);

            if ($product) {
                $item->info = $product;
                $carry->push($item);
            }

            return $carry;
        }, new Collection);
    }

    protected static function getProductInfo($key)
    {
        $decoded = static::decodeKey($key);

        $product = Product::getCartItem($decoded['id'], $decoded['options']);
        $product->options = $decoded['options'];

        return $product;
    }

    protected static function setSyncTime()
    {
        Session::put(static::getSessionKey('sync-time'), time());
    }

    public static function getSyncTime()
    {
        return Session::get(static::getSessionKey('sync-time'), 0);
    }

    protected static function getSessionKey($key)
    {
        return static::$sessionKey . '::' . $key;
    }

    /**
     * Декодируют ключ предмета из корзины. Возвращает массив из id и параметров товара.
     *
     * @param String $key
     * @return array
     */
    protected static function decodeKey(string $key): array
    {
        $keyArray = explode('-', $key);

        return [
            'id' => $keyArray[0],
            'options' => array_slice($keyArray, 1)
        ];
    }
}
