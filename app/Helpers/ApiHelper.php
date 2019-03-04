<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 22/01/2018
 * Time: 14:15
 */

namespace App\Helpers;


use Illuminate\Http\Response;

class ApiHelper
{

    public static function sendResponse($message, $error_code)
    {
        return response()->json([
            'info' => $message,
            'status' => Response::$statusTexts[$error_code],
            'status_code' => $error_code
        ])->setStatusCode($error_code, Response::$statusTexts[$error_code]);
    }
}