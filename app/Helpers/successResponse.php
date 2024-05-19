<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

function successResponse($data, $message = 'عملیات با موفقیت انجام شد'): JsonResponse
{
    return response()->json([
        'success' => true,
        'data' => $data,
        'message' => $message
    ]);
}

?>
