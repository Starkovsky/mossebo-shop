<?php

namespace App\Models;

use MosseboShopCore\Models\City as BaseCity;
use Laravel\Scout\Searchable;

class City extends BaseCity
{
    use Searchable;

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
