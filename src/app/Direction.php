<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $table = 'directions';

    public function cityFrom()
    {
        return $this->hasOne(City::class, 'code', 'city_code_from');
    }

    public function cityTO()
    {
        return $this->hasOne(City::class, 'code', 'city_code_to');
    }
}
