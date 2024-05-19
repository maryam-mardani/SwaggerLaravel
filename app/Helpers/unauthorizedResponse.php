<?php
namespace App\Helpers;
use App\Enums\ResponseCode;

use Illuminate\Http\JsonResponse;

function unauthorizedResponse($message, $code, $status = ResponseCode::NOT_ALLOW): JsonResponse
{
    return response()->json([
        'success' => false,
        'message' => $message !== '' ? $message : __("common.notAllow")
    ], $code);
}


?>
