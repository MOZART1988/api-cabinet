<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var Order $this
        */
        $data = parent::toArray($request);

        unset($data['direction']);

        return array_merge($data, ['direction' => DirectionResource::collection($this->direction()->get())]);
    }
}
