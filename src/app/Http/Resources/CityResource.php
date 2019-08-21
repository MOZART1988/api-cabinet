<?php

namespace App\Http\Resources;

use App\City;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
         * @var $this City
        */
        $data = parent::toArray($request);

        return array_merge($data, ['country' => $this->country]);
    }
}
