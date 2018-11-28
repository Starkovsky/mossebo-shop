<?php

if (!function_exists('imagePath')) {
    function imagePath($path): string
    {
        return 'http://admin.mossebo.market' . $path;
    }
}
