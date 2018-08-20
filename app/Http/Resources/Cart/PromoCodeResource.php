<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
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
            'name'    => $this->resource->name,
            'percent' => $this->resource->percent,
        ];

        if ($this->resource->amount) {
            $data['amount'] = $this->resource->amount;
        }

        return $data;
    }
}
