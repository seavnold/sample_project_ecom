<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as Controller;
use App\Models\Status;

class BaseController extends Controller
{
    /**
     * success response method.
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = Status::OK)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = Status::NOT_FOUND)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}