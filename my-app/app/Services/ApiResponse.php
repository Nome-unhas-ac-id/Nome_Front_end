<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'Berhasil.', int $status = 200): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message, 'data' => $data, 'errors' => null], $status)->header('Cache-Control', 'no-store');
    }

    public static function error(string $message, int $status, ?array $errors = null): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'data' => null, 'errors' => $errors], $status)->header('Cache-Control', 'no-store');
    }
}
