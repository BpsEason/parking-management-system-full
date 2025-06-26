<?php
namespace App\Http\Responses;
use Illuminate\Http\JsonResponse;
class ApiResponse
{
    public static function success($data = [], $message = 'Success', $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    public static function error($message, $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
}
