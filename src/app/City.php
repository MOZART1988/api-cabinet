<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public function country()
    {
        $this->hasOne(Country::class, 'code', 'country_code');
    }
}
