<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse($data, $message = 'Success', $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  array   $errors
     * @param  int     $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendError($message, $errors = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
