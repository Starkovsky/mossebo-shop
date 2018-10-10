<?php

namespace App\Models;

use MosseboShopCore\Models\City as BaseCity;

class City extends BaseCity
{
    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function postalCodes()
    {
        return $this->morphMany(PostalCode::class, 'item');
    }
}
