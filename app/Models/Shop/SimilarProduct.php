<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\SimilarProduct as BaseSimilarProduct;

class SimilarProduct extends BaseSimilarProduct
{
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'product_id',
        'similar_id'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function similar()
    {
        return $this->belongsTo(Product::class, 'similar_id');
    }
}
