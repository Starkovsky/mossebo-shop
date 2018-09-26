<?php

namespace App\Seo;

use SEOMeta;
use OpenGraph;
use Twitter;
use SEO;
use MosseboShopCore\Models\Base\BaseModel;

use App\Contracts\SeoProxy as SeoProxyInterface;

class SeoProxy implements SeoProxyInterface
{
    public static function setTitle(string $title = null): void
    {
        if (!is_null($title)) {
            SEO::setTitle($title);
        }
    }

    public static function setDescription(string $description = null): void
    {
        if (!is_null($description)) {
            SEO::setDescription($description);
        }
    }

    public static function setImage(string $pathToImage): void
    {
        OpenGraph::addImage($pathToImage);
    }

    public static function setMetaFromModel(BaseModel $modelObj): void
    {
        $title = static::getMetaFromModelByKey($modelObj, 'title');

        if (! is_null($title)) {
            static::setTitle($title);
        }

        $description = static::getMetaFromModelByKey($modelObj, 'description');

        if (! is_null($title)) {
            static::setDescription($description);
        }
    }

    protected static function getMetaFromModelByKey(BaseModel $modelObj, $key): ?string
    {
        $metaKey = 'meta_' . $key;

        if (isset($modelObj[$metaKey])) {
            return $modelObj[$metaKey];
        }

        if (isset($modelObj[$key])) {
            return $modelObj[$key];
        }

        return null;
    }

    public static function setImageFromModel(BaseModel $modelObj, string $conversionName): void
    {
        if ($modelObj->relationNotEmpty('image')) {
            $image = $modelObj->image;
        }
        elseif ($modelObj->relationNotEmpty('images')) {
            $image = $modelObj->images()->first();
        }
        else {
            return;
        }

        if (!isset($image->pathes)) {
            return;
        }

        $pathes = json_decode($image->pathes, true);

        if (!isset($pathes[$conversionName])) {
            return;
        }

        $imageData = $pathes[$conversionName];

        if (is_array($imageData)) {
            if (isset($imageData['src'])) {
                $path = $imageData['src'];
            }
            elseif (isset($imageData['srcset'])) {
                $path = $imageData['srcset'];
            }
        }
        else {
            $path = $pathes[$conversionName];
        }

        if (isset($path) && !empty($path)) {
            static::setImage(url($path));
        }
    }


    public static function generate($minify = null): string
    {
        Twitter::setUrl(url('/'));
        OpenGraph::setUrl(url('/'));

        return SEO::generate($minify);
    }
}
