<?php

namespace App\Models;

use MosseboShopCore\Models\City as BaseCity;

class City extends BaseCity
{
    protected $fillable = [
        'lat',
        'lon',
        'region_id',
        'name',
        'short_name',
        'postal_code',
        'enabled',
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
