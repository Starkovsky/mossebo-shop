<?php

namespace App\Models\Shop\Attribute;

use MosseboShopCore\Models\Shop\Attribute\Attribute as BaseAttribute;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Product\ProductAttribute;
use App\Support\Traits\Models\HasI18n;

class Attribute extends BaseAttribute
{
    use HasI18n;

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
