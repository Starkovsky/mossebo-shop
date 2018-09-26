<?php

namespace App\Repositories\Shop;

use Illuminate\Support\Collection;
use MosseboShopCore\Repositories\Shop\AttributeRepository as BaseAttributeRepository;
use App\Models\Shop\Attribute\Attribute;

class AttributeRepository extends BaseAttributeRepository
{
    public function getCollectionRaw(): Collection
    {
        return Attribute::enabled()
            ->orderBy('position', 'asc')
            ->with([
                'options' => function ($query) {
                    $query->enabled()
                        ->orderBy('position', 'asc');
                }
            ])->get();
    }
}
