<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\JsonDecoder;

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
                $errors[] = ["receiver[$key]" => ['Не может быть пустым']];
            }

            $receiver = !empty($shipping['receiver']) ? $shipping['receiver'] : null;

            if (empty($receiver['contact_phone'])) {
                $errors[] = ["receiver[contact_phone][$key]" => ['Не может быть пустым']];
            }

            if (empty($receiver['contact_person'])) {
                $errors[] = ["receiver[contact_person][$key]" => ['Не может быть пустым']];
            }

            if (empty($shipping['cargo'])) {
                $errors[] = ['cargo' => ['Не может быть пустым']];
            }

            $cargo = !empty($shipping['cargo']) ? $shipping['cargo'] : null;

            if (empty($cargo['payment_type'])) {
                $errors[] = ["cargo[payment_type][$key]" => ['Не может быть пустым']];
            }

            if (empty($cargo['payment_method'])) {
                $errors[] = ["cargo[payment_method][$key]" => ['Не может быть пустым']];
            }

            if (empty($cargo['shipment_type'])) {
                $errors[] = ["cargo[shipment_type][$key]" => ['Не может быть пустым']];
            }
        }

        return $errors;
    }

    public function add(Request $request)
    {
        $data = str_replace("'", "\"", $request->instance()->getContent());
        $data = json_decode($data, true, 512, JSON_UNESCAPED_UNICODE);

        if (json_last_error() !== 0) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => json_last_error_msg()
            ], 500);
        }

        $consignor = !empty($data['consignor']) ? $data['consignor'] : null;

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

        $shippings = $data['shippings'] ? $data['shippings'] : null;

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
