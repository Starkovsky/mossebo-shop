<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\RoomRepository as BaseRoomRepository;
use App\Models\Shop\Room\Room;

class RoomRepository extends BaseRoomRepository
{
    public function getCollectionRaw(): Collection
    {
        return Room::enabled()
            ->withProductCount()
            ->with('image')
            ->get();
    }
}
