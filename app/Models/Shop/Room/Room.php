<?php

namespace App\Models\Shop\Room;

use App\Models\Media;

use MosseboShopCore\Models\Shop\Room\Room as BaseRoom;
use App\Models\Shop\Product\Product;
use App\Models\Shop\Product\ProductCount;
use App\Support\Traits\Models\HasI18n;

class Room extends BaseRoom
{
    use HasI18n;

    public function productsRelations()
    {
        return $this->hasMany(RoomProduct::class, $this->relationFieldName);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, RoomProduct::class,
            $this->relationFieldName, 'id', 'id', 'product_id'
        );
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('collection_name', 'image')
            ->orderBy('order_column', 'asc');
    }

    protected function productCounts()
    {
        return $this->hasMany(ProductCount::class, $this->relationFieldName);
    }
}
