<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1C extends Model
{
    protected $guarded = ['updated_at', 'repeat_password'];

    protected $table = 'contragents_1C';

    public $timestamps = false;
}
