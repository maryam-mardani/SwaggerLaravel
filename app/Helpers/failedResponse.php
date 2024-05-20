<?php
namespace App\Helpers;
use App\Enums\ResponseCode;

use Illuminate\Http\JsonResponse;

function failedResponse($code,$message = 'Failed', $status = ResponseCode::OK): JsonResponse
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'code' => $code
    ], $status);
}


?>
