<?php
if (!function_exists('json')) {
    function json($data = null, $status = 200, $headers = [], $options = 0)
    {
        return new \App\Http\JsonResponse($data, $status, $headers, $options);
    }
}

