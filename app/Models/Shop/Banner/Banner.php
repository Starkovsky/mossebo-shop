<?php

namespace App\Models\Shop\Banner;

use MosseboShopCore\Models\Shop\Banner\Banner as BaseBanner;

class Banner extends BaseBanner
{
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

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
