<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Attribute as BaseAttribute;

class Attribute extends BaseAttribute
{
    public function productRelations()
    {
        return $this->hasMany(ProductAttribute::class, $this->relationFieldName);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductAttribute::class,
            $this->relationFieldName,
            'id',
            'id',
            'product_id'
        );
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, $this->relationFieldName);
    }
}
