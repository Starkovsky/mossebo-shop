<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeUseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource->relationIsEmpty('code')) {
            $code = $this->resource->code()->first();
        }
        else {
            $code = $this->resource->code;
        }

        if (is_null($code)) {
            return null;
        }

        $data = (new PromoCodeResource($code))->toArray($request);

        $data['amount'] = $this->resource->amount;
        $data['percent'] = $this->resource->percent;

        return $data;
    }
}
