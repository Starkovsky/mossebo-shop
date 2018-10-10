<?php

namespace App\Models;

use MosseboShopCore\Models\PostalCode as BasePostalCode;

class PostalCode extends BasePostalCode
{
    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
