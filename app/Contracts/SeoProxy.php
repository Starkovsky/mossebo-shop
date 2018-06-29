<?php

namespace App\Contracts;

use MosseboShopCore\Models\Base\BaseModel;

interface SeoProxy
{
    public static function setTitle(string $title = null): void;

    public static function setDescription(string $description = null): void;

    public static function setImage(string $pathToImage): void;

    public static function setMetaFromI18nModel(BaseModel $modelObj): void;

    public static function setImageFromModel(BaseModel $modelObj, string $conversionName): void;

    public static function generate($minify = null): string;
}
