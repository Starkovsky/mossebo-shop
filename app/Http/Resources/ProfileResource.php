<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id'           => $this->resource->id,
            'first_name'   => $this->resource->first_name,
            'last_name'    => $this->resource->last_name,
            'email'        => $this->resource->email,
            'phone'        => $this->resource->phone,
            'city'         => $this->resource->city,
            'street'       => $this->resource->street,
            'house_number' => $this->resource->house_number,
            'apartment'    => $this->resource->apartment,
            'floor'        => $this->resource->floor,
            'entrance'     => $this->resource->entrance,
            'intercom'     => $this->resource->intercom,
            'post_code'    => $this->resource->post_code,
            'socials'      => array_column($this->resource->socialProviders->toArray(), 'provider')
        ];
    }
}
