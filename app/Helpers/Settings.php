<?php

if (!function_exists('settings')) {
    function settings($key)
    {
        return Settings::get($key);
    }
}
