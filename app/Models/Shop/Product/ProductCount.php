<?php

namespace App\Models\Shop\Product;

use MosseboShopCore\Models\Shop\Product\ProductCount as BaseProductCount;

class ProductCount extends BaseProductCount
{
    protected $fillable = [
        'category_id',
        'room_id',
        'style_id',
        'count'
    ];
}
