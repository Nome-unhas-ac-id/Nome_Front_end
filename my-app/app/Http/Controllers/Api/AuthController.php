<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $user = User::where('email', strtolower(trim($data['email'])))->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return ApiResponse::error('Email atau password salah.', 401);
        }
        $expiry = now()->addDays(7);
        $token = $user->createToken('nome', ['*'], $expiry);

        return ApiResponse::success([
            'token' => $token->plainTextToken, 'token_type' => 'Bearer', 'expires_at' => $expiry->toISOString(),
            'user' => $user->only(['id', 'name', 'email']),
        ], 'Login berhasil.');
    }

    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success($request->user()->only(['id', 'name', 'email']));
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return ApiResponse::success(message: 'Logout berhasil.');
    }
}
