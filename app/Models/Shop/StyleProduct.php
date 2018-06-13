<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\StyleProduct as BaseStyleProduct;

class StyleProduct extends BaseStyleProduct
{
    public function styles()
    {
        return $this->belongsTo(Style::class, 'style_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
