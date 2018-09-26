<?php

namespace App\Models\Shop\Product;

use MosseboShopCore\Models\Shop\Product\ProductSale as BaseProductSale;

class ProductSale extends BaseProductSale
{
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
