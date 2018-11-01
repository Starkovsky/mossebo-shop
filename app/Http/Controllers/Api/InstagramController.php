<?php

namespace App\Http\Controllers\Api;

use App\Instagram\Instagram;
use Psy\Util\Json;

class InstagramController extends ApiController
{
    public function getImages($count = 8)
    {
        $count = min(
            8,
            max(30, $count)
        );

        return 'showInstagramWidget(' . json_encode(Instagram::getLastImages()->splice(0, $count), JSON_UNESCAPED_UNICODE) . ')';
    }
}
