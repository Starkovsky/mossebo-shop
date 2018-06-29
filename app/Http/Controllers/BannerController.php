<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected static $banners = [
        [
            'id' => 1,
            'image' => '/assets/images/tmp/header-test-1.jpg',
            'mobile_image' => '/assets/images/tmp/header-test-mobile-1.jpg',
            'title' => '',
            'link' => '/catalog/tekstil'
        ]
    ];

    public function getHeaderBanner()
    {
        $banner = static::findRelevantHeaderBanner();

        return $banner ? (object) $banner : false;
    }

    protected static function findRelevantHeaderBanner()
    {
        $url = pathUrl(request()->url());

        $banners = array_reduce(static::$banners, function($carry, $banner) use($url) {
            if ($banner['link'] !== $url) {
                $carry[] = $banner;
            }

            return $carry;
        }, []);

        $bannersCount = count($banners);

        if ($bannersCount === 0) {
            return false;
        }

        return $banners[random_int(0, $bannersCount - 1)];
    }
}
