<?php

namespace App\Models\Shop\Supplier;

use MosseboShopCore\Models\Shop\Supplier\Supplier as BaseSupplier;
use App\Models\Shop\Product\Product;

class Supplier extends BaseSupplier
{
    public function products()
    {
        return $this->hasMany(Product::class, $this->relationFieldName);
    }
}
