<?php

namespace App\Http\Resources\Cart;

use Shop;
use App\Http\Resources\Cart\PromoCodeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'key'      => $this->resource->getKey(),
            'quantity' => $this->resource->getQuantity(),
            'info' => [
                'id'      => $this->resource->getProductId(),
                'options' => $this->resource->getOptions(),
                'added'   => $this->resource->getAddedAtTimestamp(),
                'updated' => $this->resource->getUpdatedAtTimestamp(),
            ]
        ];

        $this->setPrice($data['info']);
        $this->setTitle($data['info']);
        $this->setImage($data['info']);

        return $data;
    }

    protected function setPrice(& $data)
    {
        $user = \Auth::user();

        if (is_null($user)) {
            $priceTypeId = Shop::getDefaultPriceTypeId();
        }
        else {
            $priceTypeId = $user->getPriceTypeId();
        }

        $price = $this->resource->getFinalPrice(
            $priceTypeId,
            Shop::getCurrentCurrencyCode()
        );

        $data['price'] = $price->getValue();
    }

    protected function setTitle(& $data)
    {
        $title = $this->resource->getTitle(app()->getLocale());

        if (empty($title)) {
            // todo: подгрузить заголовок из модели
        }

        $data['title'] = $title;
    }

    protected function setImage(& $data)
    {
        $imagePathes = $this->resource->getImage();

        if ($imagePathes) {
            $data['image'] = [
                'src' => $imagePathes['thumb']['src'],
                'srcset' => $imagePathes['thumb']['srcset']
            ];
        }
    }
}
