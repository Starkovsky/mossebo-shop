<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Settings;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'phone' => Settings::get('notify-help-phone'),
        ];
    }
}
