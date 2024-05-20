<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

function successResponse($data, $message = 'Successful'): JsonResponse
{
    return response()->json([
        'success' => true,
        'data' => $data,
        'message' => $message
    ]);
}

?>
