<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\ProductAttribute as BaseProductAttribute;

class ProductAttribute extends BaseProductAttribute
{
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
