<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse($code, $data = null, $message = null): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
