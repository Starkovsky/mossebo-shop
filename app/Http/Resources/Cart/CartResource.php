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

        return $data;
    }
}
