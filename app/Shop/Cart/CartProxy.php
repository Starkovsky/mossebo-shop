<?php

namespace App\Shop\Cart;

use MosseboShopCore\Shop\Cart\CartProxy as BaseCartProxy;

class CartProxy extends BaseCartProxy
{
//
//    protected static function addToCart($item)
//    {
//        $item = (object) $item;
//
//        if ((int) $item->qty <= 0) return;
//
//        $exists = isset($item->info) ? $item->info : static::checkItem($item);
//
//        if ($exists) {
//            Shoppingcart::add([
//                'id' => $item->key,
//                'qty' => $item->qty,
//                'name' => 'empty',
//                'price' => 0,
//            ]);
//        }
//    }
//
//    public static function set($items, $time = 0)
//    {
//        if (static::getSyncTime() > $time) {
//            throw new \Exception('Error 389');
//        }
//
//        Shoppingcart::destroy();
//
//        foreach ($items as $item) {
//            static::addToCart($item);
//        }
//
//        static::setSyncTime();
//        Cache::forget(static::getCacheKey());
//    }
//
//    public static function clear()
//    {
//        Shoppingcart::destroy();
//        Session::forget(static::getSessionKey('sync-time'));
//        Cache::forget(static::getCacheKey());
//    }
//
//    protected static function availableItems(Collection $cartItems): Collection
//    {
//        return $cartItems->reduce(function($carry, $item) {
//            if (static::checkItem($item)) {
//                $carry->push($item);
//            }
//
//            return $carry;
//        }, new Collection);
//    }
//
//    protected static function checkItem($item) {
////        if (isset($item->id) && isset($item->options)) {
////            $decoded = [
////                'id' => $item->id,
////                'options' => $item->options,
////            ];
////        }
////        else {
////            $decoded = static::decodeKey($item->key);
////        }
//
//        return !! static::getProductByKey($item->key);
//    }
//
//    public static function getProductByKey($key) {
//        $decoded = static::decodeKey($key);
//
//        return Product::getCartItem($decoded['id'], $decoded['options']);
//    }
//
//    protected static function setSyncTime()
//    {
//        Session::put(static::getSessionKey('sync-time'), time());
//    }
//
//    public static function getSyncTime()
//    {
//        return Session::get(static::getSessionKey('sync-time'), 0);
//    }
//
//    protected static function getSessionKey($key)
//    {
//        return static::$sessionKey . '::' . $key;
//    }
//
//    /**
//     * Декодируют ключ предмета из корзины. Возвращает массив из id и параметров товара.
//     *
//     * @param String $key
//     * @return array
//     */
//    public static function decodeKey(string $key): array
//    {
//        $keyArray = explode('-', $key);
//
//        return [
//            'id' => $keyArray[0],
//            'options' => array_slice($keyArray, 1)
//        ];
//    }
}
