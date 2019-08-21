<?php

namespace App\Http\Resources;

use App\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
         * @var Country $this
        */

        $data = parent::toArray($request);

        return $data;
    }
}
