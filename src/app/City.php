<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * @property Country $country
*/
class City extends Model
{
    protected $table = 'cities';

    public function country()
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function directionsFrom()
    {
        return $this->hasMany(Direction::class, 'city_code_from', 'code');
    }

    public function directionsTo()
    {
        return $this->hasMany(Direction::class, 'city_code_to', 'code');
    }
}
