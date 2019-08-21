<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function readJsonDataFromBody(Request $request)
    {
        $data = str_replace("'", "\"", $request->instance()->getContent());
        $data = json_decode($data, true, 512, JSON_UNESCAPED_UNICODE);

        if (json_last_error() !== 0) {
            return response()->json([
                'success' => false,
                'msg' => 'incorrect format error',
                'errors' => json_last_error_msg()
            ], 500);
        }

        return $data;
    }
}
