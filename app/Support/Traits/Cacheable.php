<?php

namespace App\Support\Traits;

trait Cacheable
{
    protected static function makeCacheKey(... $keys)
    {
        $arr = array_merge([
            static::$cacheNamespace,
            app()->getLocale()
        ], $keys);

        return implode('::', $arr);
    }
}
