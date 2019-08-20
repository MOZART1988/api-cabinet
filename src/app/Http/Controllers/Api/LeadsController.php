<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lead1CResource;
use App\Http\Resources\LeadResource;
use Illuminate\Http\Request;


class LeadsController extends Controller
{
    public function list(Request $request)
    {
        $query = \Auth::user()->leads();

        return ['success' => true, 'data' => Lead1CResource::collection($query->get())];
    }
}
