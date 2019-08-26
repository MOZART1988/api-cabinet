<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function profile()
    {
        return new UserResource(\Auth::user());
    }
}
