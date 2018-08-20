<?php

if (!function_exists('formatPrice')) {
    function formatPrice($price, $currencyCode): string
    {
        return \MosseboShopCore\Shop\Price::formatPrice($price, $currencyCode);
    }
}
