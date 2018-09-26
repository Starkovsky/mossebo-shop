<?php

namespace App\Models\Shop\Attribute;

use MosseboShopCore\Models\Shop\Attribute\AttributeOption as BaseAttributeOption;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Product\ProductAttributeOption;
use App\Support\Traits\Models\HasI18n;

class AttributeOption extends BaseAttributeOption
{
    use HasI18n;

    public function attribute()
    {
        return $this->hasOne(Attribute::class, $this->relationFieldName);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, ProductAttributeOption::class,
            $this->relationFieldName, 'id', 'id', 'product_id'
        );
    }

    public function productRelations()
    {
        return $this->hasMany(ProductAttributeOption::class, $this->relationFieldName);
    }
}
