<?php

if (!function_exists('settings')) {
    function settings($key): string
    {
        return Settings::get($key);
    }
}
