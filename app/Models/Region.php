<?php

namespace App\Models;

use MosseboShopCore\Models\Region as BaseRegion;

class Region extends BaseRegion
{
    protected $fillable = [
        'country_code',
        'name',
        'short_name',
        'aoguid',

        'area_code',
        'region_code',
        'place_code',
        'city_code',

        'parent_id',
        'enabled',
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }
}
