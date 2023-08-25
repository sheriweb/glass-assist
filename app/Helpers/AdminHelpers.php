<?php

use Illuminate\Http\JsonResponse;

/**
 * @param $type
 * @param $message
 * @return array
 */
function messages($type, $message): array
{
    return array(
        'message' => $message,
        'alert-type' => $type
    );
}

/**
 * Success response method
 *
 * @param $result
 * @param $message
 * @return JsonResponse
 */
function sendApiResponse($result, $message): JsonResponse
{
    $response = [
        'success' => true,
        'message' => $message,
        'data' => $result,
    ];

    return response()->json($response, 200);
}

/**
 * Return error response
 * @param   $error
 * @param array $errorMessages
 * @param int $code
 * @return JsonResponse
 */
function sendApiError($error, array $errorMessages = [], int $code = 404): JsonResponse
{
    $response = [
        'success' => false,
        'message' => $error,
    ];

    !empty($errorMessages) ? $response['data'] = $errorMessages : null;

    return response()->json($response, $code);
}
