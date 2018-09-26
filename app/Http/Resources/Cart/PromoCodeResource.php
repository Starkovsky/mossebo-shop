<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
{
    protected $status = null;

    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'percent'     => $this->resource->percent,
            'title'       => $this->resource->title,
            'description' => $this->resource->description,
        ];

        if ($this->resource->amount) {
            $data['amount'] = $this->resource->amount;
        }

        if (! is_null($this->status)) {
            $data['status'] = $this->status;
        }

        return $data;
    }
}
