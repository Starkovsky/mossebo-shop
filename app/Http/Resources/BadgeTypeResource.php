<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BadgeTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->resource->id,
            'icon'     => $this->resource->icon,
            'color'    => $this->resource->color,
            'title'    => $this->resource->currentI18n->title,
            'position' => $this->resource->position
        ];
    }
}
