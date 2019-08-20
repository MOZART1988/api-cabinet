<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use Illuminate\Http\Request;


class LeadsController extends Controller
{
    public function list()
    {
        $query = \Auth::user()->leads();

        return ['success' => true, 'data' => LeadResource::collection($query->get())];
    }
}
