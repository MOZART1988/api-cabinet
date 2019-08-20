<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead1C extends Model
{
    protected $table = 'leads_1C';

    public function orders()
    {
        return $this->hasMany(Order::class, 'lead_id', 'lead_id');
    }
}
