<?php

namespace App\Instagram;

use Cache;
use Illuminate\Support\Collection;
use InstagramScraper\Instagram as InstagramDataGetter;
use App\Support\Traits\Cacheable;

class Instagram
{
    use Cacheable;

    protected static $cacheNamespace = 'instagram-photos';

    public static function getLastImages($profileName)
    {
        $images = Cache::remember(static::makeCacheKey($profileName), 30, function () use($profileName) {
            $instagram = new InstagramDataGetter();
            $nonPrivateAccountMedias = $instagram->getMedias($profileName, 30);

            $result = new Collection();

            foreach ($nonPrivateAccountMedias as $media) {
                $result->push([
                    'likes' => $media['likesCount'],
                    'link' => $media['link'],
                    'src' => $media['squareImages'][1],
                    'srcset' => $media['squareImages'][3],
                ]);
            }

            return $result;
        });

        return $images;
    }
}
