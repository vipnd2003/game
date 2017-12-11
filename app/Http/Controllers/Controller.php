<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function json($data = null, $status = 200, $headers = [], $options = 0)
    {
        return new \App\Http\JsonResponse($data, $status, $headers, $options);
    }

}
