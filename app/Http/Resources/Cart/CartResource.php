<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\PromoCodeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'products' => CartProductResource::collection(
                $this->resource->getProducts()
            )
        ];

        $promoCode = $this->resource->getPromoCode();

        if (! is_null($promoCode)) {
            $data['promoCode'] = new PromoCodeResource($promoCode);
        }
    }
}


/***
 *  key: '100120',
    qty: 2,
    info: {
        id: '100120',
        title: 'Светильник подвесной Twister 30',
        image: {
            src: '/uploads/media/product/658/responsive-images/5afad84bf39a8928923862___thumb_80_80.jpg',
            srcset: '/uploads/media/product/658/responsive-images/5afad84bf39a8928923862___thumb_160_160.jpg',
        },
        price: '5500',
        category: 'Освещение',
    }
 */
