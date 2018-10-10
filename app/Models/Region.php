<?php

namespace App\Models;

use MosseboShopCore\Models\Region as BaseRegion;

class Region extends BaseRegion
{
    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function postalCodes()
    {
        return $this->morphMany(PostalCode::class, 'item');
    }
}
