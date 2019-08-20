<?php

namespace App\Http\Resources;

use App\Lead1C;
use Illuminate\Http\Resources\Json\JsonResource;

class Lead1CResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Lead1C $this */

        $data = parent::toArray($request);

        return array_merge($data,
            ['orders' => OrdersResource::collection($this->orders()->get())]
        );
    }
}
