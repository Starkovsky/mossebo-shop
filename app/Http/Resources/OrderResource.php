<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Cart\PromoCodeUseResource;

class OrderResource extends JsonResource
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
            'id'         => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name'  => $this->resource->last_name,
            'phone'      => $this->resource->phone,
            'email'      => $this->resource->email,
            'post_code'  => $this->resource->post_code,
            'city'       => $this->resource->city,
            'address'    => $this->resource->address,
            'comment'    => $this->resource->comment,
            'products'   => OrderProductResource::collection($this->resource->orderProducts),
            'updated'    => strtotime($this->resource->updated_at),
            'created'    => strtotime($this->resource->created_at)
        ];

        // isset потому что это не отношение
        if (isset($this->resource->status)) {
            $data['status'] = [
                'name' => $this->resource->status->currentI18n->name,
                'color' => $this->resource->status->color
            ];
        }

        if (isset($this->resource->payType)) {
            $data['payType'] = $this->resource->payType;
        }

        if (isset($this->resource->deliveryType)) {
            $data['deliveryType'] = $this->resource->deliveryType;
        }

        if ($this->resource->relationNotEmpty('promoUse')) {
            $data['promo'] = new PromoCodeUseResource($this->resource->promoUse);
        }

        return $data;
    }
}
