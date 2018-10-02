<?php

namespace App\Support\Traits;

use Shop;

trait Cacheable
{
    protected static function makeCacheKey(... $keys)
    {
        $arr = array_merge([
            static::$cacheNamespace,
            app()->getLocale(),
            Shop::getCurrentPriceTypeId()
        ], $keys);

        return implode('::', $arr);
    }
}
