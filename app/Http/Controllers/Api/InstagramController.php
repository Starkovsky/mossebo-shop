<?php

namespace App\Http\Controllers\Api;

use App\Instagram\Instagram;

class InstagramController extends ApiController
{
    public function getImages($count = 8)
    {
        $count = min(
            8,
            max(30, $count)
        );

        return Instagram::getLastImages()->splice(0, $count);
    }
}
