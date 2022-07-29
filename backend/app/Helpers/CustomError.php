<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class CustomError
{
    public static $ERROR_STATUS = [
        'bad_request' => Response::HTTP_BAD_REQUEST, // To be used when
        'not_authorized' => Response::HTTP_UNAUTHORIZED,
        'forbidden' => Response::HTTP_FORBIDDEN,
        'method_not_allowed' => Response::HTTP_METHOD_NOT_ALLOWED,
        'not_found' => Response::HTTP_NOT_FOUND,
        'unprocessable_request' => Response::HTTP_UNPROCESSABLE_ENTITY,
        'large_file' => Response::HTTP_REQUEST_ENTITY_TOO_LARGE,
        'media_type' => Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
        'server'=>  Response::HTTP_INTERNAL_SERVER_ERROR,
        'ok'=>  Response::HTTP_OK,
        'conflict'=> Response::HTTP_CONFLICT,
        'created'=> Response::HTTP_CREATED,
    ];

    public static $ERROR_DATA = [
        // 00* Basic errors
        '00001' => [
            'message' => 'Unknown error!',
            'shortener' => 'bad_request',
        ],
        '00002' => [
            'message' => 'Method not allowed!',
            'shortener' => 'method_not_allowed',
        ],
        '00003' => [
            'message' => 'Not found!',
            'shortener' => 'not_found',
        ],
        '00004' => [
            'message' => 'Invalid Input For Submit',
            'shortener' => 'bad_request',
        ],
        '00005' => [
            'message' => 'Unauthenticated.',
            'shortener' => 'not_authorized',
        ],

        /*
         * User Part - 10
         */
        '10001' => [
            'message' => 'User Not Found',
            'shortener' => 'bad_request',
        ],
        '10002' => [
            'message' => 'Password Not Correct',
            'shortener' => 'unprocessable_request',
        ],
        '10003' => [
            'message' => 'User Not Admin',
            'shortener' => 'forbidden',
        ],

        /*
         * Product and Comment Part - 20
         */
        '20001' => [
            'message' => 'Can not add new comment',
            'shortener' => 'server',
        ],
        '20002' => [
            'message' => 'User Already added 2 comment',
            'shortener' => 'unprocessable_request',
        ],

    ];

    public static function create(string $errorCode = '00001')
    {
        return self::getErrorObject($errorCode);
    }

    public static function getErrorObject(string $errorCode)
    {
        return [
            'code' => $errorCode,
            'message' => self::$ERROR_DATA[$errorCode]['message'],
        ];
    }

    public static function getErrorStatus(string $errorCode)
    {
        return self::$ERROR_STATUS[self::$ERROR_DATA[$errorCode]['shortener']];
    }
}
