<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders_new';

    public function direction()
    {
        return $this->hasOne(Direction::class, 'code', 'direction');
    }
}
