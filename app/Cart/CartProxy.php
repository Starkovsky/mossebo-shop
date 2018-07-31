<?php

namespace App\Cart;

use Cart;
use Cache;
use Session;
use App\Models\Shop\Product;
use Illuminate\Support\Collection;

class CartProxy
{
    protected static $sessionKey = 'cart-session';
    protected static $cacheKey = 'cart-cache';

    public static function get()
    {
        return Cache::remember(static::getCacheKey(), 5, function () {
            $items = static::getContent();

            $checked = static::availableItems($items);

            if ($items->count() !== $checked->count()) {
                static::set($checked);
            }

            $ids = [];
            $options = [];

            $checked->each(function($item) use (&$ids, &$options) {
                $ids[] = $item->id;
                $options[$item->id] = $item->options;
            });

            $products = Product::whereIn('id', $ids)
                ->with(['image', 'prices', 'currentI18n'])
                ->get();

            return $checked->map(function($item) use($products, $options) {
                $product = $products->where('id', $item->id)->first();
                $product->options = $options[$product->id];
                $item->info = $product;

                return $item;
            });
        });
    }

    protected static function getCacheKey()
    {
        return static::$cacheKey . '::' . Session::getId();
    }

    protected static function getContent(): Collection
    {
        return Cart::content()->map(function($item) {
            $decoded = static::decodeKey($item->id);

            return (object) [
                'key' => $item->id,
                'qty' => $item->qty,
                'id'  => $decoded['id'],
                'options' => $decoded['options'],
            ];
        });
    }

    public static function add($item)
    {
        static::addToCart($item);

        Cache::forget(static::getCacheKey());
    }

    protected static function addToCart($item)
    {
        $item = (object) $item;

        if ((int) $item->qty <= 0) return;

        $exists = isset($item->info) ? $item->info : static::checkItem($item);

        if ($exists) {
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
            static::addToCart($item);
        }

        static::setSyncTime();
        Cache::forget(static::getCacheKey());
    }

    public static function clear()
    {
        Cart::destroy();
        Session::forget(static::getSessionKey('sync-time'));
        Cache::forget(static::getCacheKey());
    }

    protected static function availableItems(Collection $cartItems): Collection
    {
        return $cartItems->reduce(function($carry, $item) {
            if (static::checkItem($item)) {
                $carry->push($item);
            }

            return $carry;
        }, new Collection);
    }

    protected static function checkItem($item) {
//        if (isset($item->id) && isset($item->options)) {
//            $decoded = [
//                'id' => $item->id,
//                'options' => $item->options,
//            ];
//        }
//        else {
//            $decoded = static::decodeKey($item->key);
//        }

        return !! static::getProductByKey($item->key);
    }

    public static function getProductByKey($key) {
        $decoded = static::decodeKey($key);

        return Product::getCartItem($decoded['id'], $decoded['options']);
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
    public static function decodeKey(string $key): array
    {
        $keyArray = explode('-', $key);

        return [
            'id' => $keyArray[0],
            'options' => array_slice($keyArray, 1)
        ];
    }
}
