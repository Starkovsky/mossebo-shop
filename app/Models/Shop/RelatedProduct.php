<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\RelatedProduct as BaseRelatedProduct;

class RelatedProduct extends BaseRelatedProduct
{
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'related_id'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function related()
    {
        return $this->belongsTo(Product::class, 'related_id');
    }
}
