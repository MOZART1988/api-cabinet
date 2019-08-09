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

        $receiver = $request->post('receiver');

        if ($receiver == null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['receiver' => ['Не может быть пустым']]
            ], 422);
        }

        $cargo = $request->post('cargo');

        if ($cargo == null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['cargo' => ['Не может быть пустым']]
            ], 422);
        }

        $shipmentType = $request->post('shipment_type');

        if ($shipmentType == null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['shipmentType' => ['Не может быть пустым']]
            ], 422);
        }

        $response = $this->sparkApi->addOrder(
            $consignor,
            $shipmentType,
            $receiver,
            $cargo,
        $request->has('shippings') ? $request->post('shippings') : []);

        return response()->json([
            'success' => true,
            'data' => $response
        ]);

    }
}
