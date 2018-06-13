<?php

namespace App\Models\Shop;

use MosseboShopCore\Models\Shop\RoomProduct as BaseRoomProduct;

class RoomProduct extends BaseRoomProduct
{
    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
