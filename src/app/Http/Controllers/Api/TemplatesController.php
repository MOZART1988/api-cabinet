<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplatesController extends Controller
{
    public $sparkApi = null;

    public function __construct()
    {
        $this->sparkApi = new Spark();
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
        $object = $request->post('object');

        if ($object === null) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['object' => ['Не может быть пустым']]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $this->sparkApi->addTemplate($object)
        ]);
    }
}
