<?php

namespace App\Models;

use MosseboShopCore\Models\City as BaseCity;

class City extends BaseCity
{
    protected $fillable = [
        'lat',
        'lon',
        'country_code',
        'name',
        'region',
        'cdek_code',
        'fias_code',
        'kladr_code',
        'enabled',
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function postCodes()
    {
        return $this->hasMany(PostCode::class, 'city_id', 'id');
    }
}
