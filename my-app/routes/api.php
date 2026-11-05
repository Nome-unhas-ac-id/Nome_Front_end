<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemoController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
Route::middleware('auth:sanctum')->name('api.')->group(function (): void {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('memos', MemoController::class)->whereUuid('memo');
    Route::get('memos/{memo}/preview', [MemoController::class, 'preview'])->whereUuid('memo');
});
