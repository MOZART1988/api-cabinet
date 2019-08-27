<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\SparkApi\Spark;
use Illuminate\Http\Request;


class LeadsController extends Controller
{
    private $sparkApiClient;

    public function __construct()
    {
        $this->sparkApiClient = new Spark();
    }

    public function list()
    {
        $query = \Auth::user()->leads();

        return ['success' => true, 'data' => LeadResource::collection($query->get())];
    }

    public function report()
    {
        $response = $this->sparkApiClient->requestReport();

        if ($response['success'] === false) {
            return response()->json([
                'success' => false,
                'msg' => $response['msg'],
            ]);
        }

        return ['success' => true, 'data' => $response];
    }
}
