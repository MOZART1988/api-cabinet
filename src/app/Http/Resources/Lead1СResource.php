<?php

namespace App\Http\Resources;

use App\Lead1С;
use Illuminate\Http\Resources\Json\JsonResource;

class Lead1СResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Lead1С $this */

        return parent::toArray($request);
    }
}
