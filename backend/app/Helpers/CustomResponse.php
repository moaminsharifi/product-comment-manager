<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;

class CustomResponse extends Facade
{
    /**
     * Create Success response.
     *
     * @param array $data
     * @return void
     */
    public static function createSuccess($data = [])
    {
        $responseData = [
            'ok' => 1,
            'data' => $data,
        ];

        return response($responseData, Response::HTTP_OK);
    }

    /**
     * Create Error response.
     *
     * @param string $errorCode
     * @param array $errorData
     * @return void
     */
    public static function createError(string $errorCode = '00001', $errorData = [])
    {
        $responseData = [
            'ok' => 0,
            'error' => CustomError::create($errorCode),
            'data' => $errorData,
        ];

        return response($responseData, CustomError::getErrorStatus($errorCode));
    }

    /**
     * Create error response but as array for storing in log.
     *
     * @param string $errorCode
     * @param array $errorData
     * @return void
     */
    public static function createErrorString(string $errorCode, $errorData = [])
    {
        return [
            'ok' => false,
            'error' => CustomError::create($errorCode),
            'data' => $errorData,
        ];
    }
}
