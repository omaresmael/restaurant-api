<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('jsonResponse')) {
    function jsonResponse(string $message, ?array $data = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
