<?php

namespace App\Http\Resources;

use App\Direction;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectionResource extends JsonResource
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
         * @var Direction $this
        */

        $data = parent::toArray($request);

        return array_merge($data, [
            'cityFrom' => $this->cityFrom()->get(),
            'cityTo' => $this->cityTo()->get()
        ]);
    }
}
