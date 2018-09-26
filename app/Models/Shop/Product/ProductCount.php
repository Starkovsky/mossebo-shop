<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\ProductCount as BaseProductCount;

class ProductCount extends BaseProductCount
{
    protected $fillable = [
        'category_id', 'room_id', 'style_id', 'count'
    ];
}
