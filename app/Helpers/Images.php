<?php

if (!function_exists('imagePath')) {
    function imagePath($path): string
    {
        return 'https://admin.mossebo.market' . $path;
    }
}
