<?php

namespace App\Models;

use MosseboShopCore\Models\PostCode as BasePostCode;

class PostCode extends BasePostCode
{
    protected $fillable = [
        'code', 'city_id'
    ];

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
