<?php

if (! function_exists('baseUrl')) {
    function baseUrl()
    {
        return Request::root();
    }
}

if (! function_exists('siteUrl')) {
    function siteUrl($url = '')
    {
        return trim(join('/', [
            baseUrl(),
            App::getLocale(),
            trim ($url, '/')
        ]), '/');
    }
}

if (! function_exists('apiUrl')) {
    function apiUrl($url = '')
    {
        return trim(join('/', [
            baseUrl(),
            'api',
            App::getLocale(),
            trim ($url, '/')
        ]), '/');
    }
}

if (! function_exists('pathUrl')) {
    function pathUrl($url = '')
    {
        return str_replace(baseUrl() . '/' . App::getLocale(), '', $url);
    }
}


