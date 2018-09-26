<?php

namespace App\Models\Shop\Banner;

use MosseboShopCore\Models\Shop\Banner\Banner as BaseBanner;
use App\Support\Traits\Models\HasI18n;

class Banner extends BaseBanner
{
    use HasI18n;

    public function placeRelations()
    {
        return $this->hasOne(BannerPlaceRelation::class, 'banner_id', 'id');
    }

    public function places()
    {
        return $this->hasManyThrough(
            BannerPlace::class, BannerPlaceRelation::class,
            $this->relationFieldName, 'id', 'id', 'place_id'
        );
    }
}
