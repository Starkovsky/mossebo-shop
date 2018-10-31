<?php

namespace App\Instagram;

use Cache;
use Illuminate\Support\Collection;
use InstagramScraper\Instagram as InstagramDataGetter;

class Instagram
{
    public static function getLastImages()
    {
        $images = Cache::remember('users', 30, function () {
            $instagram = new InstagramDataGetter();
            $nonPrivateAccountMedias = $instagram->getMedias('mossebo.official', 30);

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
