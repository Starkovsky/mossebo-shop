<?php

namespace App\Http\Resources;

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
        if ($this->resource->relationIsEmpty('currentI18n')) {
            $i18n = $this->resource->currentI18n()->first();
        }
        else {
            $i18n = $this->resource->currentI18n;
        }

        $data = [
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'percent'     => $this->resource->percent,
            'title'       => $i18n->title,
            'description' => $i18n->description,
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
