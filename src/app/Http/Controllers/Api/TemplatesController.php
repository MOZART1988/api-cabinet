<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplatesController extends Controller
{
    public $sparkApi = null;

    public function __construct()
    {
        $this->sparkApi = new Spark(\Auth::user()->id);
    }

    public function list()
    {
        return response()->json([
            'success' => true,
            'data' => $this->sparkApi->listTemplates()
        ]);
    }

    public function add(Request $request)
    {
        $data = $this->readJsonDataFromBody($request);

        $result = $this->sparkApi->addTemplate($data);

        if ($result['Status'] === 'Ошибка') {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => $result['Status']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
