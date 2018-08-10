<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Settings;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];

        if ($this->relationNotEmpty('region')) {
            $regionName = [];

            $regionName[] = $this->region->name . ' ' . $this->region->short_name;

            foreach ($this->region->ancestors as $ancestor) {
                $regionName[] = $ancestor->name . ' ' . $ancestor->short_name;
            }

            $data['region'] = implode(', ', $regionName);
        }

        return $data;
    }
}
