<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $table = 'leads_new';

    public function orders()
    {
        return $this->hasMany(Order::class, 'lead_id', 'lead_id')
            ->whereNotNull('waybill')
            ->where('waybill', '!=', '');
    }

}
