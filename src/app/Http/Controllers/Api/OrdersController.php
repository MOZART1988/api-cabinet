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

        if (empty($consignor['contact_person'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['consignor[contact_person]' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($consignor['contact_phone'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['consignor[contact_phone]' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($consignor['city'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['consignor[city]' => ['Не может быть пустым']]
            ], 422);
        }

        $receiver = $request->post('receiver');

        if ($receiver === null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['receiver' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($receiver['contact_phone'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['receiver[contact_phone]' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($receiver['contact_person'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['receiver[contact_person]' => ['Не может быть пустым']]
            ], 422);
        }

        $cargo = $request->post('cargo');

        if ($cargo === null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['cargo' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($cargo['payment_type'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['cargo[payment_type]' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($cargo['payment_method'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['cargo[payment_method]' => ['Не может быть пустым']]
            ], 422);
        }

        if (empty($cargo['shipment_type'])) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['cargo[shipment_type]' => ['Не может быть пустым']]
            ], 422);
        }

        $response = $this->sparkApi->addOrder($consignor, $receiver, $cargo);

        if (!empty($response['Status']) && ($response['Status'] === 'Ошибка')) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => $response
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $response
        ]);

    }
}
