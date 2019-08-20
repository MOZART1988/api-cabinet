<?php

namespace App\Http\Resources;

use App\Lead;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Lead $this */

        $data = parent::toArray($request);

        return array_merge($data,
            ['invoices' => OrdersResource::collection($this->orders()->get())]
            );
    }
}
