<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
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


        return ['success' => true, 'data' => $this->sparkApiClient->requestInvoice($invoiceNumber)];
    }
}
