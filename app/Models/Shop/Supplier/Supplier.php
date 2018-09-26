<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Supplier as BaseSupplier;

class Supplier extends BaseSupplier
{
    public function products()
    {
        return $this->hasMany(Products::class, $this->relationFieldName);
    }
}
