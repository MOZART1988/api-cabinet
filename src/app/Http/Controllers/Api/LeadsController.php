<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lead1СResource;
use App\Lead1С;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function showByNumber(Request $request)
    {
        $orderNumber = $request->get('order_number');

        if (!$orderNumber) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['order_number' => ['Не может быть пустым']]
            ], 422);
        }

        $lead = Lead1С::where('order_number', '=', $orderNumber)->first();

        if ($lead === null) {
            return response()->json(
                [
                    'success'=> false,
                    'msg' => 'Заказ не найден',
                ], 404
            );
        }

        return ['success' => true, 'data' => new Lead1СResource($lead)];
    }
}
