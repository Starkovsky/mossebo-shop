<?php

namespace App\Shop\Sale;

use App\Models\Shop\Sale\Sale as SaleModel;
use MosseboShopCore\Contracts\Models\HasMorphRelation;

class Sale
{
    protected $sales = null;

    public function getSales()
    {
        if (is_null($this->sales)) {
            $this->sales = SaleModel::enabled()->get()->reduce(function($carry, $item) {
                if (! isset($carry[$item->item_type])) {
                    $carry[$item->item_type] = [];
                }

                $carry[$item->item_type][$item->item_id] = $item;

                return $carry;
            }, []);
        }

        return $this->sales;
    }

    public function getSale($type, $id)
    {
        $sales = $this->getSales();

        return isset($sales[$type][$id]) ? $sales[$type][$id] : false;
    }

    public function getSaleTime($sale)
    {
        return [
            'start' => strtotime($sale->date_start),
            'finish' => strtotime($sale->date_finish),
        ];
    }

    public function hasActualSale($type, $id)
    {
        if ($sale = $this->getSale($type, $id)) {
            $range = $this->getSaleTime($sale);
            $time = time();

            return $time >= $range['start'] && $time <= $range['finish'];
        }

        return false;
    }

    public function itemHasSale(HasMorphRelation $item)
    {
        return !! $this->getSale($item->getMorphTypeName(), $item->id);
    }

    public function getItemSaleTime(HasMorphRelation $item)
    {
        return $this->getSaleTime(
            $this->getSale($item->getMorphTypeName(), $item->id)
        );
    }
}
