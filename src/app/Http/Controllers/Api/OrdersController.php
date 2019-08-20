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

    protected function validateShipments($shippings) {

        $errors = [];

        foreach ($shippings as $key => $shipping) {
            if (empty($shipping['receiver'])) {
                $errors[] = [
                    $key => ['receiver' => ['Не может быть пустым']]
                ];
            }

            $receiver = $shipping['receiver'];

            if (empty($receiver['contact_phone'])) {
                $errors[] = [
                    $key => ['receiver[contact_phone]' => ['Не может быть пустым']]
                ];
            }

            if (empty($receiver['contact_person'])) {
                $errors[] = [
                    $key => ['receiver[contact_person]' => ['Не может быть пустым']]
                ];
            }

            if (empty($shipping['cargo'])) {
                $errors[] = [
                    $key => ['cargo' => ['Не может быть пустым']]
                ];
            }

            if (empty($cargo['payment_type'])) {
                $errors[] = [
                    $key => ['cargo[payment_type]' => ['Не может быть пустым']]
                ];
            }

            if (empty($cargo['payment_method'])) {
                $errors[] = [
                    $key => ['cargo[payment_method]' => ['Не может быть пустым']]
                ];
            }

            if (empty($cargo['shipment_type'])) {
                $errors[] = [
                    $key => ['cargo[shipment_type]' => ['Не может быть пустым']]
                ];
            }
        }

        return $errors;
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

        $shippings = $request->post('shippings');

        if (empty($shippings)) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['shippings' => ['Не может быть пустым']]
            ], 422);
        }

        $errorsShipment = $this->validateShipments($shippings);

        if (!empty($errorsShipment)) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => $errorsShipment
            ], 422);
        }

        $response = $this->sparkApi->addOrder($consignor, $shippings);

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
