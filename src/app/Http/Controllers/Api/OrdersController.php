<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public $sparkApi;

    public function __construct()
    {
        $this->sparkApi = new Spark();
    }

    public function add(Request $request)
    {
        $consignor = $request->post('consignor');

        if ($consignor == null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['consignor' => ['Не может быть пустым']]
            ], 422);
        }



        $shippings = $request->post('shippings');

        if ($shippings == null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['shippings' => ['Не может быть пустым']]
            ], 422);
        }

        $response = $this->sparkApi->addOrder($consignor, $shippings);

        return response()->json([
            'success' => true,
            'data' => $response
        ]);

    }
}
