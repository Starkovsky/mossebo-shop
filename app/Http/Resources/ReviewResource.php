<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id'            => $this->resource->id,
            'uid'           => $this->resource->user_id,
            'user_name'     => $this->resource->user->getFullName(),
            'rate'          => $this->resource->rate,
            'advantages'    => $this->resource->advantages,
            'disadvantages' => $this->resource->disadvantages,
            'comment'       => $this->resource->comment,
            'usage_time'    => $this->resource->usage_time,
            'created'       => strtotime($this->resource->created_at),
            'likes'         => new LikeResource($this->resource)
        ];

        if (! $this->resource->confirmed) {
            $data['unconfirmed'] = true;
        }

        return $data;
    }
}
