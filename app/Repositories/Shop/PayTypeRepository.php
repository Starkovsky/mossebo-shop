<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\PayTypeRepository as BasePayTypeRepository;
use App\Models\Shop\PayType\PayType;

class PayTypeRepository extends BasePayTypeRepository
{
    public function getCollectionRaw(): Collection
    {
        return PayType::enabled()
            ->orderBy('position', 'asc')
            ->get();
    }
}
