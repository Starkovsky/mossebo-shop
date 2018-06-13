<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\Room as BaseRoom;

class Room extends BaseRoom
{
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
}
