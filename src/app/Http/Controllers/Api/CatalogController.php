<?php

namespace App\Http\Controllers\Api;

use App\SparkApi\Spark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public $sparkApiClient;

    public function __construct()
    {
        $this->sparkApiClient = new Spark();
    }

    public function getCatalogByType(Request $request)
    {
        $catalogType = $request->get('catalog');

        if (!$catalogType) {
            return response()->json([
                'success' => false,
                'msg' => 'validation_errors',
                'errors' => ['catalog' => ['Не может быть пустым']]
            ], 422);
        }

        $response = $this->sparkApiClient->requestCatalog($catalogType);

        if ($response['success'] === false) {
            return response()->json([
                'success' => false,
                'msg' => $response['msg'],
            ]);
        }


        return response()->json(['success' => true, 'data' =>$response['data']]);

    }
}
