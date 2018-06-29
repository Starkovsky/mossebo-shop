<?php

if (! function_exists('baseUrl')) {
    function baseUrl()
    {
        $server = request()->server;

        return $server->get('REQUEST_SCHEME') . '://' . $server->get('SERVER_NAME');
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


