<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{
    public $sparkApiClient;

    public function __construct()
    {
        $this->sparkApiClient = new Spark();
    }

    public function getInvoiceByNumber(Request $request)
    {
        $invoiceNumber = $request->get('invoiceNumber');

        if (!$invoiceNumber) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['invoiceNumber' => ['Не может быть пустым']]
            ], 422);
        }

        $response = $this->sparkApiClient->requestInvoice($invoiceNumber);

        if ($response['success'] === false) {
            return response()->json([
                'success' => false,
                'msg' => $response['msg'],
            ]);
        }


        return response()->json(['success' => true, 'data' =>$response['data']]);

    }
}
